// PropertyGuruScrapper - Form1.cs
using System;
using System.IO;
using System.Text;
using System.Windows.Forms;
using OpenQA.Selenium;
using OpenQA.Selenium.Chrome;
using System.Threading;
using System.Collections.Specialized;
using System.Web;
using System.Diagnostics;
using Mono.Web;
using System.Net.Mail;
using System.Text.Json;
using System.Drawing;
using System.Collections.Generic;
using MySql.Data.MySqlClient;

namespace PropertyGuruScrapper
{
    public partial class autog : Form
    {
        private IWebDriver driver;
        private bool isPaused = false;
        private bool shouldStop = false;
        private string outputFilePath;

        public autog()
        {
            InitializeComponent();
        }

        private void Form1_Load(object sender, EventArgs e)
        {
            outputFilePath = $"PropertyGuru_{DateTime.Now:yyyyMMdd}.txt";
            comboBox1.SelectedIndex = 0;

            try
            {
                foreach (var process in Process.GetProcessesByName("chrome"))
                {
                    process.Kill();
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Failed to kill Chrome processes: " + ex.Message);
            }
            LoadConfig();
        }

        private void btnLaunchBrowser_Click(object sender, EventArgs e)
        {
            try
            {
                Process proc = new Process();
                proc.StartInfo.FileName = textBox3.Text; // chrome.exe path

                string url = comboBox1.SelectedItem?.ToString() ?? "";
                string chromeArgs =
                    "--remote-debugging-port=" + textBox4.Text + " " +
                    "--user-data-dir=\"" + textBox1.Text.Trim() + "\" " +
                    "--profile-directory=" + textBox2.Text.Trim() + " " +
                    "--new-window " +
                    url;

                proc.StartInfo.Arguments = chromeArgs;


                proc.Start();


                Thread.Sleep(3000);

                ChromeOptions options = new ChromeOptions();
                options.DebuggerAddress = "127.0.0.1:" + textBox4.Text;
                driver = new ChromeDriver(options);
                SaveConfig();
            }
            catch (Exception ex)
            {
                MessageBox.Show("Error launching browser: " + ex.Message);
            }
            btnLaunchBrowser.BackColor = Color.Red;
        }

        private void btnScrapePages_Click(object sender, EventArgs e)
        {
            if (driver == null)
            {
                MessageBox.Show("Launch the browser first.");
                return;
            }

            string baseUrl = comboBox1.SelectedItem?.ToString();
            if (string.IsNullOrEmpty(baseUrl))
            {
                MessageBox.Show("Please select a base URL.");
                return;
            }

            int startPage = (int)numericUpDown1.Value;
            int endPage = (int)numericUpDown2.Value;

            string connectionString = "server=157.173.209.199;user=u229715236_Scrap;password=Karachi@786!;database=u229715236_Scrap;SslMode=none;";

            isPaused = false;
            shouldStop = false;
            btnScrapePages.Enabled = false;
            btnResume.Enabled = true;

            // Start scraping in a separate thread to keep UI responsive
            Thread scrapingThread = new Thread(() => {
                for (int page = startPage; page <= endPage; page++)
                {
                    if (shouldStop)
                        break;

                    while (isPaused)
                    {
                        Thread.Sleep(1000); // Wait while paused
                        if (shouldStop)
                            break;
                    }

                    try
                    {
                        driver.Navigate().GoToUrl($"{baseUrl}{page}");
                        Thread.Sleep(3000);

                        // Check for Cloudflare challenge
                        if (IsCloudflareChallenge())
                        {
                            SetStatus("⚠️ Cloudflare challenge detected! Pausing for human verification...");
                            PauseForHumanVerification();
                            continue; // After resume, retry the same page
                        }

                        var articles = driver.FindElements(By.XPath("//article[contains(@class, 'list-item-new')]"));

                        foreach (var article in articles)
                        {
                            if (isPaused || shouldStop)
                                break;

                            try
                            {
                                string price = article.GetAttribute("data-price") ?? "0";
                                var anchor = article.FindElement(By.CssSelector("a.item-link"));
                                string title = anchor?.GetAttribute("title") ?? "N/A";
                                string href = anchor?.GetAttribute("href") ?? "";
                                string adUrl = "https://www.autogidas.lt" + href;

                                // Extract ModelYear and Make from title
                                string modelYear = "0";
                                string make = "";
                                string modelName = "";

                                try
                                {
                                    // Get the first parameter which should be the year (e.g., "2017-12")
                                    var yearElement = article.FindElement(By.CssSelector(".parameters .parameter-value"));
                                    string yearText = yearElement?.Text?.Trim() ?? "";
                                    if (!string.IsNullOrEmpty(yearText) && yearText.Contains("-"))
                                    {
                                        modelYear = yearText.Split('-')[0]; // Get "2017" from "2017-12"
                                    }
                                }
                                catch { }

                                // Extract make and model name from title
                                if (!string.IsNullOrEmpty(title) && title != "N/A")
                                {
                                    string[] titleParts = title.Split(' ');
                                    if (titleParts.Length > 0)
                                    {
                                        make = titleParts[0]; // "Volkswagen" from "Volkswagen Golf"
                                    }
                                    if (titleParts.Length > 1)
                                    {
                                        modelName = titleParts[1]; // "Golf" from "Volkswagen Golf"
                                    }
                                }

                                string sellerName = "";
                                string sellerVerified = "0";

                                try
                                {
                                    var nameEl = article.FindElement(By.CssSelector(".company-name"));
                                    sellerName = nameEl?.Text?.Trim() ?? "";

                                    if (article.Text.Contains("Verified partner"))
                                        sellerVerified = "1";
                                }
                                catch { }

                                using (var conn = new MySqlConnection(connectionString))
                                {
                                    conn.Open();
                                    string insertSql = @"INSERT INTO car_ads (title, price, ModelYear, ModelName, Make, ad_url, seller_name, seller_verified, scrapStatus)
         SELECT @title, @price, @ModelYear, @ModelName, @Make, @ad_url, @seller_name, @seller_verified, 'pending'
         WHERE NOT EXISTS (SELECT 1 FROM car_ads WHERE ad_url = @ad_url)";

                                    using (var cmd = new MySqlCommand(insertSql, conn))
                                    {
                                        cmd.Parameters.AddWithValue("@title", title);
                                        cmd.Parameters.AddWithValue("@price", price);
                                        cmd.Parameters.AddWithValue("@ModelYear", modelYear);
                                        cmd.Parameters.AddWithValue("@ModelName", modelName);
                                        cmd.Parameters.AddWithValue("@Make", make);
                                        cmd.Parameters.AddWithValue("@ad_url", adUrl);
                                        cmd.Parameters.AddWithValue("@seller_name", sellerName);
                                        cmd.Parameters.AddWithValue("@seller_verified", sellerVerified);
                                        cmd.ExecuteNonQuery();
                                    }
                                }
                                Counter++;
                            }
                            catch (Exception ex)
                            {
                                SetStatus($"❌ Inner ad error: {ex.Message}");
                            }
                        }
                        SetStatus($"✅ Page {page} completed. Total items: {Counter}");
                    }
                    catch (Exception ex)
                    {
                        SetStatus($"❌ Page {page} error: {ex.Message}");
                        
                        // Check if the error might be related to Cloudflare
                        if (ex.Message.Contains("timeout") || IsCloudflareChallenge())
                        {
                            SetStatus("⚠️ Possible Cloudflare challenge detected! Pausing for human verification...");
                            PauseForHumanVerification();
                            page--; // Retry the same page after human verification
                        }
                    }
                }

                // Update UI when scraping is complete
                Invoke(new Action(() => {
                    btnScrapePages.Enabled = true;
                    btnScrapePages.BackColor = Color.Green;
                    SetStatus($"✅ Scraping completed. Total items: {Counter}");
                }));
            });

            scrapingThread.IsBackground = true;
            scrapingThread.Start();
        }

        private bool IsCloudflareChallenge()
        {
            try
            {
                // Look for common Cloudflare challenge elements
                var cloudflareElements = driver.FindElements(By.CssSelector(
                    "div#cf-challenge-running, " +
                    "div.cf-browser-verification, " +
                    "div#cf-please-wait, " +
                    "iframe[src*='challenges.cloudflare.com'], " +
                    "div#challenge-running, " +
                    "div#challenge-stage, " +
                    "div.ray-id, " +
                    "div.cf-error-title, " +
                    "div.cf-error-code"));
                
                if (cloudflareElements.Count > 0)
                    return true;
                
                // Check for common Cloudflare text in page source
                string pageSource = driver.PageSource.ToLower();
                if (pageSource.Contains("cloudflare") && 
                    (pageSource.Contains("security check") || 
                     pageSource.Contains("please wait") || 
                     pageSource.Contains("challenge") ||
                     pageSource.Contains("human verification") ||
                     pageSource.Contains("checking your browser")))
                {
                    return true;
                }
                
                return false;
            }
            catch
            {
                return false;
            }
        }

        private void PauseForHumanVerification()
        {
            Invoke(new Action(() => {
                isPaused = true;
                btnResume.BackColor = Color.Yellow;
                btnResume.Text = "Resume (After Verification)";
                // Play a sound to alert user
                System.Media.SystemSounds.Exclamation.Play();
                // Show a notification
                MessageBox.Show("Cloudflare challenge detected! Please complete the verification in the browser, then click Resume.", 
                    "Human Verification Required", MessageBoxButtons.OK, MessageBoxIcon.Warning);
            }));
        }

        private void btnResume_Click(object sender, EventArgs e)
        {
            isPaused = false;
            btnResume.BackColor = SystemColors.Control;
            btnResume.Text = "Resume";
            SetStatus("✅ Resumed scraping");
        }

        private void SetStatus(string text)
        {
            if (InvokeRequired)
            {
                Invoke(new Action(() => lblStatus.Text = text));
            }
            else
            {
                lblStatus.Text = text;
            }
        }
        int Counter = 0;
        private void textBox3_TextChanged(object sender, EventArgs e)
        {

        }


        public void SendEmail(string DesEmail)
        {
                {
                    SmtpClient client = new SmtpClient();
                    client.DeliveryMethod = SmtpDeliveryMethod.Network;
                    client.EnableSsl = true;
                    client.Host = "smtp.gmail.com";
                    client.Port = 587;
                    string specialKey = "jiuqobkapbgmisos";
                    // setup Smtp authentication
                    System.Net.NetworkCredential credentials =
                        new System.Net.NetworkCredential("hussainrox555@gmail.com", specialKey);
                    client.UseDefaultCredentials = false;
                    client.Credentials = credentials;

                    MailMessage msg = new MailMessage();
                    msg.From = new MailAddress("hussainrox555@gmail.com");
                    msg.To.Add(new MailAddress(DesEmail));
                    msg.Subject = string.Format(DateTime.Now.ToLongDateString() + " PropertyGuru source");
                    msg.Body =string.Format(DateTime.Now.ToLongDateString() + " PropertyGuru source");
                // return;
                string fileName = "PropertyGuru_" + DateTime.Now.ToString("yyyyMMdd") + ".txt";
                string exePath = Application.StartupPath;
                string outputFilePath = Path.Combine(exePath, fileName);


                if (File.Exists(outputFilePath))
                {
                    Attachment attachment1 = new System.Net.Mail.Attachment(outputFilePath);
                    msg.Attachments.Add(attachment1);
                }
                else
                {
                    MessageBox.Show("File not found: " + outputFilePath);
                }

                client.Send(msg);

            }
            try
                {
                }
            
            catch (Exception ex)
            {
            }
        }

        private void btnEmail_Click(object sender, EventArgs e)
        {
            SendEmail(textBox5.Text);
            btnEmail.BackColor = Color.Green;
        }
        private string configPath = "config.txt";
        private void SaveConfig()
        {
            var config = new
            {
                UserDataDir = textBox1.Text.Trim(),
                ProfileDir = textBox2.Text.Trim(),
                DebugPort = textBox4.Text.Trim(),
                Email = textBox5.Text.Trim()

            };

            File.WriteAllText(configPath, JsonSerializer.Serialize(config));
        }
        private void LoadConfig()
        {
            if (File.Exists(configPath))
            {
                var json = File.ReadAllText(configPath);
                var config = JsonSerializer.Deserialize<dynamic>(json);

                textBox1.Text = config?.GetProperty("UserDataDir").GetString() ?? "";
                textBox2.Text = config?.GetProperty("ProfileDir").GetString() ?? "";
                textBox4.Text = config?.GetProperty("DebugPort").GetString() ?? "";
                textBox5.Text = config?.GetProperty("Email").GetString() ?? "";


            }
        }

        private void textBox5_TextChanged(object sender, EventArgs e)
        {

        }
    }
}
