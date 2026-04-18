plugins {
    id("com.android.application")
    id("kotlin-android")
    // The Flutter Gradle Plugin must be applied after the Android and Kotlin Gradle plugins.
    id("dev.flutter.flutter-gradle-plugin")
    id("com.google.gms.google-services")
}

import java.util.Properties
import java.io.FileInputStream

val keyProperties = Properties()
val keyPropertiesFile = rootProject.file("key.properties")
if (keyPropertiesFile.exists()) {
    keyProperties.load(FileInputStream(keyPropertiesFile))
}

android {
    namespace = "com.foodnpals.fnpRestaurantEmployee"
    compileSdk = 36
    // NDK r28+ emits 16 KB ELF alignment (Play requirement for API 35+). Flutter default is still r27.
    ndkVersion = "28.2.13676358"

    compileOptions {
        sourceCompatibility = JavaVersion.VERSION_11
        targetCompatibility = JavaVersion.VERSION_11
    }

    kotlinOptions {
        jvmTarget = JavaVersion.VERSION_11.toString()
    }

    defaultConfig {
        // TODO: Specify your own unique Application ID (https://developer.android.com/studio/build/application-id.html).
        applicationId = "com.foodnpals.fnpRestaurantEmployee"
        // You can update the following values to match your application needs.
        // For more information, see: https://flutter.dev/to/review-gradle-config.
        minSdk = flutter.minSdkVersion
        targetSdk = 36
        versionCode = flutter.versionCode
        versionName = flutter.versionName

        // Play Store 16 KB page size: only package arm64-v8a. armeabi-v7a / x86 / x86_64
        // prebuilt .so from Flutter plugins are often still 4 KB–aligned; one bad ABI
        // fails the whole AAB upload. Real devices on Play are overwhelmingly arm64.
        // (Debug on x86 emulator: use an arm64 system image, or temporarily add ABI.)
        ndk {
            abiFilters += listOf("arm64-v8a")
        }
    }

    signingConfigs {
        create("release") {
            keyAlias = keyProperties["keyAlias"] as String?
            keyPassword = keyProperties["keyPassword"] as String?
            storeFile = if (keyProperties["storeFile"] != null) project.file(keyProperties["storeFile"] as String) else null
            storePassword = keyProperties["storePassword"] as String?
        }
    }

    buildTypes {
        release {
            // TODO: Add your own signing config for the release build.
            // Signing with the debug keys for now, so `flutter run --release` works.
            signingConfig = signingConfigs.getByName("release")
        }
    }

    // AGP 8.5.1+: uncompressed JNI + 16 KB zip alignment in bundles; do not use legacy compressed packaging.
    packaging {
        jniLibs {
            useLegacyPackaging = false
        }
    }
}

tasks.withType<org.jetbrains.kotlin.gradle.tasks.KotlinCompile>().configureEach {
    incremental = false
}

flutter {
    source = "../.."
}

dependencies {
    implementation("androidx.constraintlayout:constraintlayout:2.1.4")
    implementation("androidx.cardview:cardview:1.0.0")
    implementation("androidx.appcompat:appcompat:1.6.1")
}
