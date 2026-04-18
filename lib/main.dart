import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:audioplayers/audioplayers.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'dart:async';
import 'dart:math' as math;
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'qr_scanner_screen.dart';
import 'utils/api_utils.dart';
import 'utils/snackbar_utils.dart';
import 'utils/fcm_utils.dart';
import 'utils/session_manager.dart';

// Background message handler
Future<void> _firebaseMessagingBackgroundHandler(RemoteMessage message) async {
  await Firebase.initializeApp();
  print('Handling a background message: ${message.messageId}');
}

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await Firebase.initializeApp();
  
  // Set up background message handler
  FirebaseMessaging.onBackgroundMessage(_firebaseMessagingBackgroundHandler);
  
  // Request notification permissions
  await FirebaseMessaging.instance.requestPermission(
    alert: true,
    badge: true,
    sound: true,
  );
  
  SystemChrome.setSystemUIOverlayStyle(const SystemUiOverlayStyle(
    statusBarColor: Colors.transparent,
    statusBarIconBrightness: Brightness.dark,
  ));
  
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'FnP - Restaurant Employee',
      theme: ThemeData(
        primarySwatch: Colors.green,
        useMaterial3: true,
        colorScheme: ColorScheme.fromSeed(
          seedColor: const Color(0xFF4CBB17), // Kelly green
          brightness: Brightness.light,
        ),
        scaffoldBackgroundColor: const Color(0xFF50B849),
        elevatedButtonTheme: ElevatedButtonThemeData(
          style: ElevatedButton.styleFrom(
            backgroundColor: const Color(0xFF4CBB17),
            foregroundColor: Colors.white,
          ),
        ),
        inputDecorationTheme: InputDecorationTheme(
          filled: true,
          fillColor: const Color(0xFFF5F5F5),
          border: OutlineInputBorder(
            borderRadius: BorderRadius.circular(12),
            borderSide: BorderSide.none,
          ),
        ),
      ),
      home: const AuthWrapper(),
      debugShowCheckedModeBanner: false,
    );
  }
}

class AuthWrapper extends StatefulWidget {
  const AuthWrapper({super.key});

  @override
  State<AuthWrapper> createState() => _AuthWrapperState();
}

class _AuthWrapperState extends State<AuthWrapper> {
  bool _isLoading = true;
  bool _isLoggedIn = false;
  Map<String, dynamic>? _staffData;

  @override
  void initState() {
    super.initState();
    _checkSession();
  }

  Future<void> _checkSession() async {
    try {
      final sessionData = await SessionManager.getSession();
      if (sessionData != null) {
        setState(() {
          _isLoggedIn = true;
          _staffData = sessionData;
          _isLoading = false;
        });
      } else {
        setState(() {
          _isLoggedIn = false;
          _isLoading = false;
        });
      }
    } catch (e) {
      print('Error checking session: $e');
      setState(() {
        _isLoggedIn = false;
        _isLoading = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    if (_isLoading) {
      return const Scaffold(
        body: Center(
          child: CircularProgressIndicator(),
        ),
      );
    }

    if (_isLoggedIn && _staffData != null) {
      return DashboardScreen(staffData: _staffData!);
    }

    return const LoginScreen();
  }
}

class LoginScreen extends StatefulWidget {
  const LoginScreen({super.key});

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final _formKey = GlobalKey<FormState>();
  final _emailController = TextEditingController(text: '');
  final _passwordController = TextEditingController(text: '');
  bool _isLoading = false;
  bool _obscurePassword = true;

  @override
  void dispose() {
    _emailController.dispose();
    _passwordController.dispose();
    super.dispose();
  }

  Future<void> _updateFCMToken(int staffId) async {
    await FCMUtils.updateStaffFCMToken(staffId);
  }

  Future<void> _signInWithEmail() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() => _isLoading = true);

    try {
      // Try API login first
      final data = await ApiUtils.staffLogin(
        username: _emailController.text.trim(),
        password: _passwordController.text,
      );

      if (data['success']) {
        // Store staff data
        final staffData = data['data'];
        
        // Save session data
        await SessionManager.saveSession(staffData);
        
        // Update FCM token after successful login
        await _updateFCMToken(staffData['staff_id']);
        
        if (mounted) {
          // Navigate to dashboard with staff data
          Navigator.of(context).pushReplacement(
            MaterialPageRoute(
              builder: (_) => DashboardScreen(staffData: staffData),
            ),
          );
        }
        setState(() => _isLoading = false);
        return;
      }
      
      // Fallback to hardcoded login
      if (_emailController.text.trim() == 'admin12345' && 
          _passwordController.text == 'admin12345') {
        await Future.delayed(const Duration(milliseconds: 500));
        
        final hardcodedStaffData = {
          'staff_id': 1,
          'restaurant_id': 1,
          'first_name': 'Admin',
          'last_name': 'User',
          'email': 'admin',
          'user_type': 'admin',
          'designation': 'Manager',
          'token': 'hardcoded_token_12345'
        };
        
        // Save session data
        await SessionManager.saveSession(hardcodedStaffData);
        
        // Update FCM token for hardcoded login
        await _updateFCMToken(1);
        
        if (mounted) {
          Navigator.of(context).pushReplacement(
            MaterialPageRoute(
              builder: (_) => DashboardScreen(staffData: hardcodedStaffData),
            ),
          );
        }
        setState(() => _isLoading = false);
        return;
      }

      // Show error
      if (mounted) {
        SnackBarUtils.showError(context, 'Invalid username or password');
      }
    } catch (e) {
      // Fallback to hardcoded login on network error
      if (_emailController.text.trim() == 'admin' && 
          _passwordController.text == 'admin') {
        await Future.delayed(const Duration(milliseconds: 500));
        
        final hardcodedStaffData = {
          'staff_id': 1,
          'restaurant_id': 1,
          'first_name': 'Admin',
          'last_name': 'User',
          'email': 'admin',
          'user_type': 'admin',
          'designation': 'Manager',
          'token': 'hardcoded_token_12345'
        };
        
        // Save session data
        await SessionManager.saveSession(hardcodedStaffData);
        
        // Update FCM token for hardcoded login
        await _updateFCMToken(1);
        
        if (mounted) {
          Navigator.of(context).pushReplacement(
            MaterialPageRoute(
              builder: (_) => DashboardScreen(staffData: hardcodedStaffData),
            ),
          );
        }
      } else {
        if (mounted) {
          SnackBarUtils.showError(context, 'Network error. Please check your connection.');
        }
      }
    }
    
    setState(() => _isLoading = false);
  }


  @override
  Widget build(BuildContext context) {
    final screenHeight = MediaQuery.of(context).size.height;
    final screenWidth = MediaQuery.of(context).size.width;
    
    return Scaffold(
      backgroundColor: const Color(0xFF50B849),
      body: Column(
        children: [
          // Top 40% - Food imagery background with overlay
          Container(
            height: screenHeight * 0.4,
            width: screenWidth,
              decoration: const BoxDecoration(
                  gradient: LinearGradient(
                    begin: Alignment.topCenter,
                    end: Alignment.bottomCenter,
                    colors: [
                  Color(0xFF4CBB17),
                  Color(0xFF50B849),
                    ],
                  ),
                ),
            child: Stack(
              children: [
                // Full-cover food imagery background
                Positioned.fill(
                  child: Image.asset(
                    'assets/images/appicon.jpg',
                    fit: BoxFit.cover,
                  ),
                ),
                // Subtle dark overlay (10% opacity)
                Container(
                  decoration: BoxDecoration(
                    color: Colors.black.withOpacity(0.1),
                  ),
                ),
                // Restaurant branding over the food imagery
                Center(
                child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                            const Text(
                        '',
                              style: TextStyle(
                          fontSize: 28,
                          fontWeight: FontWeight.bold,
                                    color: Colors.white,
                          shadows: [
                            Shadow(
                              offset: Offset(0, 2),
                              blurRadius: 4,
                              color: Colors.black26,
                            ),
                          ],
                        ),
                      ),
                      const SizedBox(height: 4),
                      const Text(
                        '',
                                  style: TextStyle(
                                    fontSize: 16,
                          color: Colors.white,
                          fontWeight: FontWeight.w300,
                                  ),
                                ),
                          ],
                      ),
                    ),
                  ],
                ),
              ),
          
          // Bottom section - Clean semi-transparent white card (90% opacity)
          Expanded(
            child: Container(
              width: screenWidth,
                decoration: BoxDecoration(
                color: Colors.white.withOpacity(0.9), // 90% opacity as specified
                        borderRadius: const BorderRadius.only(
                          topLeft: Radius.circular(30),
                          topRight: Radius.circular(30),
                        ),
                boxShadow: [
                  BoxShadow(
                    color: Colors.black.withOpacity(0.1),
                    blurRadius: 20,
                    offset: const Offset(0, -5),
                  ),
                ],
              ),
              child: SingleChildScrollView(
                padding: const EdgeInsets.all(32.0),
                child: Form(
                  key: _formKey,
                        child: Column(
                    crossAxisAlignment: CrossAxisAlignment.stretch,
                          children: [
                      const SizedBox(height: 8),
                      GestureDetector(
                        onDoubleTap: () {
                          _emailController.text = 'waiter@foodnpals.com';
                          _passwordController.text = '12345';
                          setState(() {});
                        },
                        child: Text(
                          'Welcome Back!',
                                      style: TextStyle(
                            fontSize: 26,
                            fontWeight: FontWeight.bold,
                            color: Colors.grey[800],
                          ),
                          textAlign: TextAlign.center,
                                    ),
                      ),
                                  const SizedBox(height: 8),
                      Text(
                        'Sign in to continue',
                        style: TextStyle(
                          fontSize: 15,
                          color: Colors.grey[600],
                        ),
                        textAlign: TextAlign.center,
                      ),
                      const SizedBox(height: 40),
                                  TextFormField(
                                    controller: _emailController,
                        keyboardType: TextInputType.text,
                        style: TextStyle(color: Colors.grey[800]),
                                    decoration: InputDecoration(
                          labelText: 'Username',
                          labelStyle: TextStyle(color: Colors.grey[600]),
                          prefixIcon: Icon(
                            Icons.person_outlined,
                            color: const Color(0xFF4CBB17), // Fresh kelly green accent
                          ),
                                      filled: true,
                          fillColor: const Color(0xFFF5F5F5), // Light grey input field
                                      border: OutlineInputBorder(
                                        borderRadius: BorderRadius.circular(12),
                                        borderSide: BorderSide.none,
                                      ),
                          enabledBorder: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(12),
                            borderSide: BorderSide.none,
                          ),
                          focusedBorder: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(12),
                            borderSide: const BorderSide(
                              color: Color(0xFF4CBB17), // Fresh kelly green on focus
                              width: 2,
                            ),
                          ),
                        ),
                        validator: (value) {
                          if (value == null || value.isEmpty) {
                            return 'Please enter your username';
                          }
                          return null;
                        },
                      ),
                      const SizedBox(height: 20),
                                  TextFormField(
                                    controller: _passwordController,
                        obscureText: _obscurePassword,
                        style: TextStyle(color: Colors.grey[800]),
                                    decoration: InputDecoration(
                          labelText: 'Password',
                          labelStyle: TextStyle(color: Colors.grey[600]), // Soft grey text
                          prefixIcon: Icon(
                            Icons.lock_outlined,
                            color: const Color(0xFF4CBB17), // Fresh kelly green accent
                          ),
                          suffixIcon: IconButton(
                            icon: Icon(
                              _obscurePassword ? Icons.visibility_off : Icons.visibility,
                              color: Colors.grey[600], // Soft grey text
                            ),
                            onPressed: () {
                              setState(() => _obscurePassword = !_obscurePassword);
                            },
                          ),
                                      filled: true,
                          fillColor: const Color(0xFFF5F5F5), // Light grey input field
                                      border: OutlineInputBorder(
                                        borderRadius: BorderRadius.circular(12),
                                        borderSide: BorderSide.none,
                                      ),
                          enabledBorder: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(12),
                            borderSide: BorderSide.none,
                          ),
                          focusedBorder: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(12),
                            borderSide: const BorderSide(
                              color: Color(0xFF4CBB17), // Fresh kelly green on focus
                              width: 2,
                            ),
                          ),
                        ),
                        validator: (value) {
                          if (value == null || value.isEmpty) {
                            return 'Please enter your password';
                          }
                          return null;
                        },
                      ),
                      const SizedBox(height: 32),
                      ElevatedButton(
                        onPressed: _isLoading ? null : _signInWithEmail,
                                      style: ElevatedButton.styleFrom(
                          backgroundColor: const Color(0xFF4CBB17), // Fresh kelly green primary brand color
                          foregroundColor: Colors.white,
                          padding: const EdgeInsets.symmetric(vertical: 16),
                                        shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(12),
                                        ),
                          elevation: 2,
                                      ),
                        child: _isLoading
                                          ? const SizedBox(
                                              height: 20,
                                              width: 20,
                                              child: CircularProgressIndicator(
                                                strokeWidth: 2,
                                                valueColor: AlwaysStoppedAnimation<Color>(Colors.white),
                                              ),
                                            )
                                          : const Text(
                                'Sign In',
                                              style: TextStyle(
                                                fontSize: 16,
                                  fontWeight: FontWeight.bold,
                                  letterSpacing: 0.5,
                                              ),
                                            ),
                                    ),
                                  const SizedBox(height: 20),
                                  Row(
                        mainAxisAlignment: MainAxisAlignment.center,
                                    children: [
                          Container(
                            padding: const EdgeInsets.symmetric(
                              horizontal: 12,
                              vertical: 6,
                            ),
                            decoration: BoxDecoration(
                              color: const Color(0xFF4CBB17).withOpacity(0.1),
                              borderRadius: BorderRadius.circular(20),
                            ),
                            child: Row(
                              children: [
                                Icon(
                                  Icons.info_outline,
                                  size: 16,
                                  color: const Color(0xFF4CBB17),
                                ),
                                const SizedBox(width: 6),
                                Text(
                                  'Note: This app is only for restaurant\'s staff.',
                                        style: TextStyle(
                                    fontSize: 12,
                                    color: Colors.grey[700],
                                              ),
                                            ),
                                          ],
                                    ),
                                  ),
                                ],
                            ),
                          ],
                        ),
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }
}


// Models
class TableModel {
  final int tableId;
  final int number;
  final int capacity;
  String status;
  final String description;
  bool isOccupied;

  TableModel({
    required this.tableId,
    required this.number,
    required this.capacity,
    required this.status,
    required this.description,
    this.isOccupied = false,
  });

  factory TableModel.fromJson(Map<String, dynamic> json) {
    return TableModel(
      tableId: json['table_id'],
      number: json['table_number'],
      capacity: json['capacity'],
      status: json['status'],
      description: json['description'] ?? '',
      isOccupied: json['is_occupied'] ?? false,
    );
  }
}

class ReservationModel {
  final int reservationId;
  final int customerId;
  final String customerName;
  final String reservationDateTime;
  final int tableNumber;
  final String status;
  final String specialRequests;
  final int numberOfGuests;
  final String checkInTime;
  final String checkOutTime;
  final int tableId;
  final String customerLatitude;
  final String customerLongitude;
  final String restaurantLatitude;
  final String restaurantLongitude;
  final String details;
  final String phoneNumber;
  final String email;
  final String extendedTime;
  final String extendedTimeLocal;
  final String extensionReason;
  final String restaurantTimezone;

  ReservationModel({
    required this.reservationId,
    required this.customerId,
    required this.customerName,
    required this.reservationDateTime,
    required this.tableNumber,
    required this.status,
    required this.specialRequests,
    required this.numberOfGuests,
    required this.checkInTime,
    required this.checkOutTime,
    required this.tableId,
    required this.customerLatitude,
    required this.customerLongitude,
    required this.restaurantLatitude,
    required this.restaurantLongitude,
    required this.details,
    required this.phoneNumber,
    required this.email,
    this.extendedTime = '',
    this.extendedTimeLocal = '',
    this.extensionReason = '',
    this.restaurantTimezone = 'America/Detroit',
  });

  factory ReservationModel.fromJson(Map<String, dynamic> json) {
    return ReservationModel(
      reservationId: json['reservation_id'],
      customerId: json['customer_id'],
      customerName: json['customer_name'],
      reservationDateTime: json['reservation_datetime'],
      tableNumber: json['table_number'],
      status: json['status'],
      specialRequests: json['special_requests'] ?? '',
      numberOfGuests: json['number_of_guests'],
      checkInTime: json['check_in_time'] ?? '',
      checkOutTime: json['check_out_time'] ?? '',
      tableId: json['table_id'],
      customerLatitude: json['customer_latitude'] ?? '',
      customerLongitude: json['customer_longitude'] ?? '',
      restaurantLatitude: json['restaurant_latitude'] ?? '',
      restaurantLongitude: json['restaurant_longitude'] ?? '',
      details: json['details'] ?? '',
      phoneNumber: json['phone_number'] ?? '',
      email: json['email'] ?? '',
      extendedTime: json['extended_time'] ?? '',
      extendedTimeLocal: json['extended_time_local'] ?? '',
      extensionReason: json['extension_reason'] ?? '',
      restaurantTimezone: json['restaurant_timezone'] ?? 'America/Detroit',
    );
  }

  String get time {
    try {
      // Use local timezone datetime if available, otherwise fallback to UTC
      final dateTimeStr = extendedTimeLocal.isNotEmpty ? extendedTimeLocal : 
                         (extendedTime.isNotEmpty ? extendedTime : reservationDateTime);
      final dateTime = DateTime.parse(dateTimeStr);
      return '${dateTime.hour.toString().padLeft(2, '0')}:${dateTime.minute.toString().padLeft(2, '0')}';
    } catch (e) {
      return '00:00';
    }
  }
}

class OrderModel {
  final int orderId;
  final int customerId;
  final int restaurantId;
  final int reservationId;
  final String orderDateTime;
  final double totalAmount;
  final String status;
  final List<OrderDetailModel> orderDetails;

  OrderModel({
    required this.orderId,
    required this.customerId,
    required this.restaurantId,
    required this.reservationId,
    required this.orderDateTime,
    required this.totalAmount,
    required this.status,
    required this.orderDetails,
  });

  factory OrderModel.fromJson(Map<String, dynamic> json) {
    return OrderModel(
      orderId: json['order_id'],
      customerId: json['customer_id'],
      restaurantId: json['restaurant_id'],
      reservationId: json['reservation_id'],
      orderDateTime: json['order_datetime'],
      totalAmount: double.parse(json['total_amount'].toString()),
      status: json['status'],
      orderDetails: (json['order_details'] as List)
          .map((detail) => OrderDetailModel.fromJson(detail))
          .toList(),
    );
  }
}

class OrderDetailModel {
  final int detailId;
  final int menuItemId;
  final String itemName;
  final double price;
  final int quantity;
  final double subtotal;
  final String instructions;
  final String category;

  OrderDetailModel({
    required this.detailId,
    required this.menuItemId,
    required this.itemName,
    required this.price,
    required this.quantity,
    required this.subtotal,
    required this.instructions,
    required this.category,
  });

  factory OrderDetailModel.fromJson(Map<String, dynamic> json) {
    return OrderDetailModel(
      detailId: json['detail_id'],
      menuItemId: json['menu_item_id'],
      itemName: json['item_name'],
      price: double.parse(json['price'].toString()),
      quantity: json['quantity'],
      subtotal: double.parse(json['subtotal'].toString()),
      instructions: json['instructions'] ?? '',
      category: json['category'] ?? '',
    );
  }
}

class DashboardScreen extends StatefulWidget {
  final Map<String, dynamic> staffData;
  
  const DashboardScreen({super.key, required this.staffData});

  @override
  State<DashboardScreen> createState() => _DashboardScreenState();
}

class _DashboardScreenState extends State<DashboardScreen> with SingleTickerProviderStateMixin, WidgetsBindingObserver {
  List<TableModel> _tables = [];
  List<ReservationModel> _reservations = [];
  bool _isLoading = true;
  bool _bulkUpdatingTables = false;
  /// 1 = Reserve All in progress, 2 = Available All in progress
  int _bulkTableAction = 0;
  Timer? _refreshTimer;
  String _selectedReservationStatus = 'all'; // Filter for reservation status
  final Map<int, double> _reservationIdToMiles = {}; // cache reservation distance in miles
  final Set<int> _promptedPendingBookingIds = {};
  bool _pendingBookingDialogOpen = false;
  AudioPlayer? _bookingRingPlayer;
  late final AnimationController _blinkController;
  late final Animation<double> _blinkAnimation;
  static const String _googleApiKey = 'YOUR_GOOGLE_MAPS_API_KEY';

  /// Serializes overlapping refresh calls (timer + resume + pull-to-refresh).
  Future<void> _serializedLoads = Future.value();

  /// Debounces rapid lifecycle transitions before reloading from the network.
  Timer? _resumeReloadDebounce;

  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addObserver(this);
    _loadData();
    _startRefreshTimer();
    _setupFCMTokenRefresh();
    _setupFCMListeners();
    _blinkController = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 900),
      lowerBound: 0.2,
      upperBound: 1.0,
    )..repeat(reverse: true);
    _blinkAnimation = CurvedAnimation(parent: _blinkController, curve: Curves.easeInOut);
  }

  @override
  void dispose() {
    WidgetsBinding.instance.removeObserver(this);
    _resumeReloadDebounce?.cancel();
    _refreshTimer?.cancel();
    _bookingRingPlayer?.dispose();
    _blinkController.dispose();
    super.dispose();
  }

  @override
  void didChangeAppLifecycleState(AppLifecycleState state) {
    if (state == AppLifecycleState.resumed) {
      _resumeReloadDebounce?.cancel();
      _resumeReloadDebounce = Timer(const Duration(milliseconds: 350), () {
        if (!mounted) return;
        _loadData();
      });
    }
  }

  void _setupFCMTokenRefresh() {
    FCMUtils.setupTokenRefreshListener(widget.staffData['staff_id']);
  }

  void _setupFCMListeners() {
    // Foreground messages
    FirebaseMessaging.onMessage.listen((RemoteMessage message) {
      final notification = message.notification;
      if (!mounted || notification == null) return;
      final title = notification.title ?? 'New notification';
      final body = notification.body ?? '';
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('$title: $body')),
      );
    });

    // When app opened from a notification tap
    FirebaseMessaging.onMessageOpenedApp.listen((RemoteMessage message) {
      final notification = message.notification;
      if (!mounted || notification == null) return;
      // Optionally navigate or refresh reservations
      _loadReservations();
    });
  }

  Future<void> _openQRScanner() async {
    final scanned = await Navigator.of(context).push<String>(
      MaterialPageRoute<String>(
        builder: (context) => const QRCodeScannerScreen(),
      ),
    );
    if (!mounted || scanned == null || scanned.isEmpty) return;
    await _handleQRCodeScanned(scanned);
  }

  Future<void> _handleQRCodeScanned(String qrData) async {
    if (!mounted) return;
    try {
      // Simple, ideal logic: Accept either a numeric ReservationID or a URL that contains ?ID=
      final raw = qrData.trim();

      // Try extract from URL first if it looks like one
      int? bookingId;
      if (raw.startsWith('http')) {
        try {
          final uri = Uri.parse(raw);
          final idParam = uri.queryParameters['ID'] ?? uri.queryParameters['id'];
          if (idParam != null) {
            bookingId = int.tryParse(idParam);
          }
        } catch (_) {}
      }

      // If not found, try to parse the whole payload as an integer (numeric QR)
      bookingId ??= int.tryParse(raw);

      if (bookingId == null || bookingId <= 0) {
        SnackBarUtils.showError(context, 'Invalid QR Code. Please try again.');
        return;
      }

      // Confirm with the user
      final confirmed = await showDialog<bool>(
        context: context,
        builder: (context) => AlertDialog(
          title: const Text('Complete Booking'),
          content: Text('Mark booking #$bookingId as Completed?'),
          actions: [
            TextButton(onPressed: () => Navigator.of(context).pop(false), child: const Text('Cancel')),
            TextButton(onPressed: () => Navigator.of(context).pop(true), child: const Text('Complete')),
          ],
        ),
      );

      if (confirmed != true) return;

      SnackBarUtils.showLoading(context, 'Processing booking #$bookingId ...');

      // Construct canonical admin QR URL expected by API
      final qrUrl = 'https://foodnpals.com/admin/QRCode.php?ID=$bookingId';

      final data = await ApiUtils.completeBookingFromQR(
        qrUrl: qrUrl,
        staffId: widget.staffData['staff_id'],
      );

      if (data['success'] == true) {
        SnackBarUtils.showSuccess(context, 'Booking #$bookingId completed');
        _loadReservations();
      } else {
        SnackBarUtils.showError(context, data['message'] ?? 'Failed to complete booking');
      }
    } catch (e) {
      SnackBarUtils.showError(context, 'Error: $e');
    }
  }

  // Legacy handlers removed – simplified flow above handles both numeric and URL QR codes

  // Parameter QR handler removed – not needed in simplified flow


  void _startRefreshTimer() {
    // Refresh dashboard data every 60 seconds
    _refreshTimer = Timer.periodic(const Duration(seconds: 60), (timer) {
      if (mounted) {
        _loadData();
      }
    });
  }

  /// Refetches tables and reservations. [showLoadingOverlay] shows the full-screen
  /// loader (e.g. manual refresh); background/timer/resume reloads omit it.
  Future<void> _loadData({bool showLoadingOverlay = false}) {
    _serializedLoads = _serializedLoads.then((_) => _runLoadData(showLoadingOverlay));
    return _serializedLoads;
  }

  Future<void> _runLoadData(bool showLoadingOverlay) async {
    if (!mounted) return;
    if (showLoadingOverlay) {
      setState(() => _isLoading = true);
    }
    try {
      await Future.wait([
        _loadTables(),
        _loadReservations(schedulePendingPrompt: false),
      ]);
    } finally {
      if (mounted) {
        setState(() => _isLoading = false);
        _schedulePendingBookingPrompt();
      }
    }
  }

  void _schedulePendingBookingPrompt() {
    WidgetsBinding.instance.addPostFrameCallback((_) {
      if (!mounted) return;
      _presentNextPendingBookingDialog();
    });
  }

  Future<void> _playNewBookingRing() async {
    try {
      _bookingRingPlayer ??= AudioPlayer();
      await _bookingRingPlayer!.stop();
      await _bookingRingPlayer!.setReleaseMode(ReleaseMode.loop);
      await _bookingRingPlayer!.play(AssetSource('sounds/booking_ring.mp3'));
    } catch (_) {}
  }

  Future<void> _stopNewBookingRing() async {
    try {
      await _bookingRingPlayer?.stop();
    } catch (_) {}
  }

  Future<void> _presentNextPendingBookingDialog() async {
    if (!mounted || _pendingBookingDialogOpen) return;

    ReservationModel? next;
    for (final r in _reservations) {
      if (r.status.toLowerCase() == 'pending' &&
          !_promptedPendingBookingIds.contains(r.reservationId)) {
        next = r;
        break;
      }
    }
    if (next == null) return;

    _pendingBookingDialogOpen = true;
    try {
      await _playNewBookingRing();
      if (!mounted) return;

      _promptedPendingBookingIds.add(next.reservationId);
      await _showBookingActionDialog(next);
    } finally {
      await _stopNewBookingRing();
      _pendingBookingDialogOpen = false;
      if (mounted) {
        _schedulePendingBookingPrompt();
      }
    }
  }

  // Get filtered reservations based on selected status
  List<ReservationModel> get _filteredReservations {
    if (_selectedReservationStatus == 'all') {
      return _reservations;
    }
    return _reservations.where((r) => r.status.toLowerCase() == _selectedReservationStatus).toList();
  }

  // Get count for a specific status
  int _getStatusCount(String status) {
    if (status == 'all') return _reservations.length;
    return _reservations.where((r) => r.status.toLowerCase() == status).length;
  }

  // Get list of statuses with non-zero counts
  List<Map<String, dynamic>> get _statusTabs {
    final statuses = [
      {'key': 'all', 'label': 'All Bookings'},
      {'key': 'pending', 'label': 'Pending'},
      {'key': 'accepted', 'label': 'Accepted'},
      {'key': 'confirmed', 'label': 'Confirmed'},
      {'key': 'completed', 'label': 'Completed'},
      {'key': 'cancelled', 'label': 'Cancelled'},
    ];
    
    return statuses.where((status) {
      final count = _getStatusCount(status['key'] as String);
      return count > 0;
    }).toList();
  }

  Future<void> _loadTables() async {
    try {
      final data = await ApiUtils.getTables(widget.staffData['restaurant_id']);
      if (!mounted) return;
      setState(() {
        _tables = data.map((table) => TableModel.fromJson(table)).toList();
      });
    } catch (e) {
      print('Error loading tables: $e');
      if (!mounted) return;
      // ApiUtils used to return [] on failure and wiped the UI. Keep last good data when refreshing.
      if (_tables.isNotEmpty) {
        return;
      }
      setState(() {
        _tables = [
          TableModel(tableId: 1, number: 1, capacity: 4, status: 'Available', description: 'Window table', isOccupied: false),
          TableModel(tableId: 2, number: 2, capacity: 2, status: 'Reserved', description: 'Corner table', isOccupied: true),
          TableModel(tableId: 3, number: 3, capacity: 6, status: 'Available', description: 'Family table', isOccupied: false),
          TableModel(tableId: 4, number: 4, capacity: 2, status: 'Reserved', description: 'Booth', isOccupied: true),
          TableModel(tableId: 5, number: 5, capacity: 4, status: 'Available', description: 'Center table', isOccupied: false),
          TableModel(tableId: 6, number: 6, capacity: 8, status: 'Available', description: 'Large table', isOccupied: false),
        ];
      });
    }
  }

  Future<void> _loadReservations({bool schedulePendingPrompt = true}) async {
    try {
      final data = await ApiUtils.getReservations(widget.staffData['restaurant_id']);
      if (!mounted) return;
      setState(() {
        _reservations = data.map((reservation) => ReservationModel.fromJson(reservation)).toList();
      });
      // kick off async distance fetches
      for (final r in _reservations) {
        _ensureDistanceForReservation(r);
      }
      if (schedulePendingPrompt && mounted) {
        _schedulePendingBookingPrompt();
      }
    } catch (e) {
      print('Error loading reservations: $e');
      if (!mounted) return;
      if (_reservations.isNotEmpty) {
        if (schedulePendingPrompt) {
          _schedulePendingBookingPrompt();
        }
        return;
      }
      setState(() {
        _reservations = [
          ReservationModel(
            reservationId: 1,
            customerId: 1,
            customerName: 'John Smith',
            reservationDateTime: '2024-01-15 18:30:00',
            tableNumber: 2,
            status: 'Confirmed',
            specialRequests: 'Vegetarian options',
            numberOfGuests: 4,
            checkInTime: '',
            checkOutTime: '',
            tableId: 2,
            customerLatitude: '24.8607',
            customerLongitude: '67.0011',
            restaurantLatitude: '24.8607',
            restaurantLongitude: '67.0011',
            details: '',
            phoneNumber: '+1234567890',
            email: 'john@example.com',
          ),
          ReservationModel(
            reservationId: 2,
            customerId: 2,
            customerName: 'Sarah Johnson',
            reservationDateTime: '2024-01-15 19:00:00',
            tableNumber: 4,
            status: 'Confirmed',
            specialRequests: 'Birthday celebration',
            numberOfGuests: 2,
            checkInTime: '',
            checkOutTime: '',
            tableId: 4,
            customerLatitude: '24.8607',
            customerLongitude: '67.0011',
            restaurantLatitude: '24.8607',
            restaurantLongitude: '67.0011',
            details: '',
            phoneNumber: '+1234567891',
            email: 'sarah@example.com',
          ),
        ];
      });
      // compute fallback distances for hardcoded data
      for (final r in _reservations) {
        _ensureDistanceForReservation(r);
      }
      if (schedulePendingPrompt && mounted) {
        _schedulePendingBookingPrompt();
      }
    }
  }

  Future<void> _ensureDistanceForReservation(ReservationModel reservation) async {
    if (_reservationIdToMiles.containsKey(reservation.reservationId)) return;
    final customerLat = double.tryParse(reservation.customerLatitude);
    final customerLng = double.tryParse(reservation.customerLongitude);
    final restaurantLat = double.tryParse(reservation.restaurantLatitude);
    final restaurantLng = double.tryParse(reservation.restaurantLongitude);
    if (customerLat == null || customerLng == null || restaurantLat == null || restaurantLng == null) return;

    try {
      final miles = await _fetchDistanceMilesViaGoogle(customerLat, customerLng, restaurantLat, restaurantLng);
      setState(() {
        _reservationIdToMiles[reservation.reservationId] = miles;
      });
    } catch (_) {
      final miles = _computeHaversineMiles(customerLat, customerLng, restaurantLat, restaurantLng);
      setState(() {
        _reservationIdToMiles[reservation.reservationId] = miles;
      });
    }
  }

  Future<double> _fetchDistanceMilesViaGoogle(double originLat, double originLng, double destLat, double destLng) async {
    // If API key not set, throw to trigger fallback
    if (_googleApiKey.isEmpty || _googleApiKey == 'YOUR_GOOGLE_MAPS_API_KEY') {
      throw Exception('Missing Google API key');
    }
    final url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=$originLat,$originLng&destinations=$destLat,$destLng&key=$_googleApiKey';
    final response = await ApiUtils.getRequest(endpoint: url);
    if (response['status'] != 'OK') {
      throw Exception('Distance API not OK');
    }
    final elements = response['rows'][0]['elements'];
    if (elements == null || elements.isEmpty || elements[0]['status'] != 'OK') {
      throw Exception('Distance element not OK');
    }
    // value is in meters; convert to miles
    final meters = (elements[0]['distance']['value'] as num).toDouble();
    return meters / 1609.344;
  }

  double _computeHaversineMiles(double lat1, double lon1, double lat2, double lon2) {
    const double earthRadiusMiles = 3958.7613;
    final double dLat = _toRadians(lat2 - lat1);
    final double dLon = _toRadians(lon2 - lon1);
    final double a =
        math.sin(dLat / 2) * math.sin(dLat / 2) +
        math.cos(_toRadians(lat1)) * math.cos(_toRadians(lat2)) * math.sin(dLon / 2) * math.sin(dLon / 2);
    final double c = 2 * math.atan2(math.sqrt(a), math.sqrt(1 - a));
    return earthRadiusMiles * c;
  }

  double _toRadians(double deg) => deg * math.pi / 180.0;

  Future<void> _toggleTableStatus(int index) async {
    final table = _tables[index];
    final newStatus = table.isOccupied ? 'Available' : 'Reserved';
    
    print('Toggling table ${table.number} from ${table.status} to $newStatus');
    
    try {
      final success = await ApiUtils.updateTableStatus(
        tableId: table.tableId,
        status: newStatus,
      );

      if (success) {
        setState(() {
          _tables[index].isOccupied = !_tables[index].isOccupied;
          _tables[index].status = newStatus;
        });
        
        print('Table ${table.number} status updated to $newStatus');
        
        SnackBarUtils.showSuccess(
          context,
          'Table ${table.number} is now ${_tables[index].isOccupied ? "Reserved" : "Available"}',
        );
      } else {
        throw Exception('Failed to update table status');
      }
    } catch (e) {
      print('Error updating table: $e');
      SnackBarUtils.showError(context, 'Error updating table: $e');
    }
  }

  Future<void> _setAllTablesReserved() async {
    final indices = <int>[];
    for (var i = 0; i < _tables.length; i++) {
      if (!_tables[i].isOccupied) indices.add(i);
    }
    if (indices.isEmpty) {
      if (mounted) {
        SnackBarUtils.showInfo(context, 'All tables are already reserved');
      }
      return;
    }
    setState(() {
      _bulkUpdatingTables = true;
      _bulkTableAction = 1;
    });
    var failed = 0;
    for (final i in indices) {
      final table = _tables[i];
      try {
        final success = await ApiUtils.updateTableStatus(
          tableId: table.tableId,
          status: 'Reserved',
        );
        if (success && mounted) {
          setState(() {
            _tables[i].isOccupied = true;
            _tables[i].status = 'Reserved';
          });
        } else {
          failed++;
        }
      } catch (e) {
        print('Error reserving table ${table.number}: $e');
        failed++;
      }
    }
    if (!mounted) return;
    setState(() {
      _bulkUpdatingTables = false;
      _bulkTableAction = 0;
    });
    if (failed == 0) {
      SnackBarUtils.showSuccess(context, 'All tables marked reserved');
    } else {
      SnackBarUtils.showError(
        context,
        'Could not update $failed table(s). Try refresh or update individually.',
      );
    }
  }

  Future<void> _setAllTablesAvailable() async {
    final indices = <int>[];
    for (var i = 0; i < _tables.length; i++) {
      if (_tables[i].isOccupied) indices.add(i);
    }
    if (indices.isEmpty) {
      if (mounted) {
        SnackBarUtils.showInfo(context, 'All tables are already available');
      }
      return;
    }
    setState(() {
      _bulkUpdatingTables = true;
      _bulkTableAction = 2;
    });
    var failed = 0;
    for (final i in indices) {
      final table = _tables[i];
      try {
        final success = await ApiUtils.updateTableStatus(
          tableId: table.tableId,
          status: 'Available',
        );
        if (success && mounted) {
          setState(() {
            _tables[i].isOccupied = false;
            _tables[i].status = 'Available';
          });
        } else {
          failed++;
        }
      } catch (e) {
        print('Error marking table ${table.number} available: $e');
        failed++;
      }
    }
    if (!mounted) return;
    setState(() {
      _bulkUpdatingTables = false;
      _bulkTableAction = 0;
    });
    if (failed == 0) {
      SnackBarUtils.showSuccess(context, 'All tables marked available');
    } else {
      SnackBarUtils.showError(
        context,
        'Could not update $failed table(s). Try refresh or update individually.',
      );
    }
  }

  Future<void> _showBookingActionDialog(ReservationModel reservation) {
    return showDialog<void>(
      context: context,
      barrierDismissible: false,
      builder: (BuildContext context) {
        return StatefulBuilder(
          builder: (context, setState) {
            return AlertDialog(
              title: Row(
                children: [
                  const Icon(
                    Icons.notifications_active,
                    color: Color(0xFF4CBB17),
                    size: 28,
                  ),
                  const SizedBox(width: 12),
                  Expanded(
                    child: Text(
                      'Pending Booking #${reservation.reservationId}',
                      style: const TextStyle(fontSize: 18),
                    ),
                  ),
                ],
              ),
              content: SingleChildScrollView(
                child: Column(
                  mainAxisSize: MainAxisSize.min,
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    _buildInfoRow('Customer', reservation.customerName),
                    _buildInfoRow('Table', 'Table ${reservation.tableNumber}'),
                    _buildInfoRow('Guests', '${reservation.numberOfGuests}'),
                    _buildInfoRow('Time', _formatTime(reservation.reservationDateTime)),
                    if (reservation.specialRequests.isNotEmpty)
                      _buildInfoRow('Special Requests', reservation.specialRequests),
                    const SizedBox(height: 16),
                    const Text(
                      'Choose an action:',
                      style: TextStyle(
                        fontWeight: FontWeight.bold,
                        fontSize: 16,
                      ),
                    ),
                  ],
                ),
              ),
              actions: [
                TextButton.icon(
                  onPressed: () {
                    _showTableSelectionDialog(reservation);
                  },
                  icon: const Icon(Icons.table_restaurant, color: Colors.blue),
                  label: const Text('Offer Another Table'),
                  style: TextButton.styleFrom(
                    foregroundColor: Colors.blue,
                  ),
                ),
                TextButton.icon(
                  onPressed: () {
                    Navigator.of(context).pop();
                    _declineBooking(reservation);
                  },
                  icon: const Icon(Icons.cancel, color: Colors.red),
                  label: const Text('Decline'),
                  style: TextButton.styleFrom(
                    foregroundColor: Colors.red,
                  ),
                ),
                ElevatedButton.icon(
                  onPressed: () {
                    Navigator.of(context).pop();
                    _acceptBooking(reservation);
                  },
                  icon: const Icon(Icons.check_circle),
                  label: const Text('Accept'),
                  style: ElevatedButton.styleFrom(
                    backgroundColor: const Color(0xFF4CBB17),
                    foregroundColor: Colors.white,
                  ),
                ),
              ],
            );
          },
        );
      },
    );
  }

  void _showTableSelectionDialog(ReservationModel reservation) {
    int? selectedTableId;

    showDialog(
      context: context,
      builder: (BuildContext dialogContext) {
        return StatefulBuilder(
          builder: (context, setState) {
            return AlertDialog(
              title: const Text('Select Alternative Table'),
              content: Column(
                mainAxisSize: MainAxisSize.min,
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'Original Table: ${reservation.tableNumber}',
                    style: TextStyle(
                      color: Colors.grey[600],
                      fontSize: 14,
                    ),
                  ),
                  const SizedBox(height: 16),
                  const Text('Available Tables:'),
                  const SizedBox(height: 8),
                  DropdownButtonFormField<int>(
                    value: selectedTableId,
                    decoration: const InputDecoration(
                      border: OutlineInputBorder(),
                      hintText: 'Select a table',
                    ),
                    items: _tables
                        .where((table) => !table.isOccupied)
                        .map((table) => DropdownMenuItem<int>(
                              value: table.tableId,
                              child: Text(
                                'Table ${table.number} (${table.capacity} seats) - ${table.description}',
                              ),
                            ))
                        .toList(),
                    onChanged: (value) {
                      setState(() {
                        selectedTableId = value;
                      });
                    },
                  ),
                ],
              ),
              actions: [
                TextButton(
                  onPressed: () => Navigator.of(dialogContext).pop(),
                  child: const Text('Cancel'),
                ),
                ElevatedButton(
                  onPressed: selectedTableId == null
                      ? null
                      : () {
                          Navigator.of(dialogContext).pop();
                          Navigator.of(context).pop();
                          _offerAlternativeTable(reservation, selectedTableId!);
                        },
                  style: ElevatedButton.styleFrom(
                    backgroundColor: const Color(0xFF4CBB17),
                  ),
                  child: const Text('Offer Table'),
                ),
              ],
            );
          },
        );
      },
    );
  }

  Widget _buildInfoRow(String label, String value) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 4),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          SizedBox(
            width: 120,
            child: Text(
              '$label:',
              style: TextStyle(
                fontWeight: FontWeight.w500,
                color: Colors.grey[700],
              ),
            ),
          ),
          Expanded(
            child: Text(
              value,
              style: const TextStyle(
                fontWeight: FontWeight.bold,
              ),
            ),
          ),
        ],
      ),
    );
  }

  String _formatTime(String dateTimeStr) {
    try {
      final dateTime = DateTime.parse(dateTimeStr);
      return '${dateTime.hour.toString().padLeft(2, '0')}:${dateTime.minute.toString().padLeft(2, '0')}';
    } catch (e) {
      return dateTimeStr;
    }
  }

  Future<void> _acceptBooking(ReservationModel reservation) async {
    try {
      final reservationSuccess = await ApiUtils.updateReservationStatus(
        reservationId: reservation.reservationId,
        status: 'Accepted',
      );

      if (reservationSuccess) {
        final tableSuccess = await ApiUtils.updateTableStatus(
          tableId: reservation.tableId,
          status: 'Reserved',
        );

        if (tableSuccess) {
          await _loadData();

          if (mounted) {
            SnackBarUtils.showSuccess(context, 'Booking #${reservation.reservationId} accepted');
          }
        }
      }
    } catch (e) {
      if (mounted) {
        SnackBarUtils.showError(context, 'Error accepting booking: $e');
      }
    }
  }

  Future<void> _declineBooking(ReservationModel reservation) async {
    _showDeclineReasonDialog(reservation);
  }

  void _showDeclineReasonDialog(ReservationModel reservation) {
    String? selectedReason;

    showDialog(
      context: context,
      barrierDismissible: false,
      builder: (BuildContext context) {
        return StatefulBuilder(
          builder: (context, setState) {
            return AlertDialog(
              title: Row(
                children: [
                  const Icon(
                    Icons.cancel,
                    color: Colors.red,
                    size: 28,
                  ),
                  const SizedBox(width: 12),
                  Expanded(
                    child: Text(
                      'Decline Booking #${reservation.reservationId}',
                      style: const TextStyle(fontSize: 18),
                    ),
                  ),
                ],
              ),
              content: SingleChildScrollView(
                child: Column(
                  mainAxisSize: MainAxisSize.min,
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    const Text(
                      'Please select a reason for declining this booking:',
                      style: TextStyle(
                        fontSize: 16,
                        fontWeight: FontWeight.w500,
                      ),
                    ),
                    const SizedBox(height: 16),
                    _buildReasonOption(
                      'No Capacity',
                      'We are at full capacity for this time slot',
                      selectedReason == 'No Capacity',
                      () => setState(() => selectedReason = 'No Capacity'),
                    ),
                    _buildReasonOption(
                      'Closing Hours',
                      'The requested time is outside our operating hours',
                      selectedReason == 'Closing Hours',
                      () => setState(() => selectedReason = 'Closing Hours'),
                    ),
                    _buildReasonOption(
                      'Rush Hours',
                      'We are experiencing high demand during this time',
                      selectedReason == 'Rush Hours',
                      () => setState(() => selectedReason = 'Rush Hours'),
                    ),
                    _buildReasonOption(
                      'Cannot Fulfill Orders',
                      'We are unable to fulfill the requested orders',
                      selectedReason == 'Cannot Fulfill Orders',
                      () => setState(() => selectedReason = 'Cannot Fulfill Orders'),
                    ),
                    _buildReasonOption(
                      'Other',
                      'Other reason not listed above',
                      selectedReason == 'Other',
                      () => setState(() => selectedReason = 'Other'),
                    ),
                  ],
                ),
              ),
              actions: [
                TextButton(
                  onPressed: () {
                    Navigator.of(context).pop();
                  },
                  child: const Text('Cancel'),
                ),
                ElevatedButton(
                  onPressed: selectedReason == null
                      ? null
                      : () {
                          Navigator.of(context).pop();
                          _processDeclineBooking(reservation, selectedReason!);
                        },
                  style: ElevatedButton.styleFrom(
                    backgroundColor: Colors.red,
                    foregroundColor: Colors.white,
                  ),
                  child: const Text('Decline Booking'),
                ),
              ],
            );
          },
        );
      },
    );
  }

  Widget _buildReasonOption(String title, String description, bool isSelected, VoidCallback onTap) {
    return Container(
      margin: const EdgeInsets.only(bottom: 12),
      child: InkWell(
        onTap: onTap,
        borderRadius: BorderRadius.circular(8),
        child: Container(
          padding: const EdgeInsets.all(12),
          decoration: BoxDecoration(
            border: Border.all(
              color: isSelected ? Colors.red : Colors.grey[300]!,
              width: isSelected ? 2 : 1,
            ),
            borderRadius: BorderRadius.circular(8),
            color: isSelected ? Colors.red[50] : Colors.white,
          ),
          child: Row(
            children: [
              Icon(
                isSelected ? Icons.radio_button_checked : Icons.radio_button_unchecked,
                color: isSelected ? Colors.red : Colors.grey[600],
                size: 20,
              ),
              const SizedBox(width: 12),
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      title,
                      style: TextStyle(
                        fontWeight: FontWeight.bold,
                        color: isSelected ? Colors.red[700] : Colors.black87,
                      ),
                    ),
                    const SizedBox(height: 4),
                    Text(
                      description,
                      style: TextStyle(
                        fontSize: 12,
                        color: Colors.grey[600],
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Future<void> _processDeclineBooking(ReservationModel reservation, String declineReason) async {
    try {
      final success = await ApiUtils.updateReservationStatus(
        reservationId: reservation.reservationId,
        status: 'Denied',
        declineReason: declineReason,
      );

      if (success) {
        await _loadData();

        if (mounted) {
          SnackBarUtils.showInfo(context, 'Booking #${reservation.reservationId} declined - $declineReason');
        }
      }
    } catch (e) {
      if (mounted) {
        SnackBarUtils.showError(context, 'Error declining booking: $e');
      }
    }
  }

  Future<void> _offerAlternativeTable(ReservationModel reservation, int newTableId) async {
    try {
      final newTable = _tables.firstWhere((t) => t.tableId == newTableId);

      final reservationSuccess = await ApiUtils.updateReservationStatus(
        reservationId: reservation.reservationId,
        tableId: newTableId,
        tableNumber: newTable.number,
        status: 'Accepted',
      );

      if (reservationSuccess) {
        final tableSuccess = await ApiUtils.updateTableStatus(
          tableId: newTableId,
          status: 'Reserved',
        );

        if (tableSuccess) {
          await _loadData();

          if (mounted) {
            SnackBarUtils.showSuccess(
              context,
              'Booking #${reservation.reservationId} moved to Table ${newTable.number}',
            );
          }
        }
      }
    } catch (e) {
      if (mounted) {
        SnackBarUtils.showError(context, 'Error offering alternative table: $e');
      }
    }
  }

  Future<void> _signOut() async {
    // Clear session data
    await SessionManager.clearSession();
    
    // Navigate back to login screen
    if (mounted) {
      Navigator.of(context).pushReplacement(
        MaterialPageRoute(builder: (_) => const LoginScreen()),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    if (_isLoading) {
      return Scaffold(
        backgroundColor: Colors.grey[50],
        appBar: AppBar(
          title: const Text('Foodnpals - Dashboard', style: TextStyle(fontWeight: FontWeight.bold)),
          backgroundColor: const Color(0xFF4CBB17),
          foregroundColor: Colors.white,
          elevation: 0,
        ),
        body: const Center(
          child: CircularProgressIndicator(
            valueColor: AlwaysStoppedAnimation<Color>(Color(0xFF4CBB17)),
          ),
        ),
      );
    }

    return Scaffold(
      backgroundColor: Colors.grey[50],
      appBar: AppBar(
        title: const Text('Dashboard', style: TextStyle(fontWeight: FontWeight.bold)),
        backgroundColor: const Color(0xFF4CBB17),
        foregroundColor: Colors.white,
        elevation: 0,
        actions: [
          IconButton(
            icon: const Icon(Icons.refresh),
            onPressed: () => _loadData(showLoadingOverlay: true),
            tooltip: 'Refresh',
          ),
          IconButton(
            icon: const Icon(Icons.logout),
            onPressed: _signOut,
            tooltip: 'Sign Out',
          ),
        ],
      ),
      body: SafeArea(
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(16.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // Welcome Section
              Card(
                elevation: 3,
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(16),
                ),
                child: Container(
                  width: double.infinity,
                  padding: const EdgeInsets.all(24),
                  decoration: BoxDecoration(
                    gradient: const LinearGradient(
                      colors: [
                        Color(0xFF4CBB17),
                        Color(0xFF50B849),
                      ],
                      begin: Alignment.topLeft,
                      end: Alignment.bottomRight,
                    ),
                    borderRadius: BorderRadius.circular(16),
                  ),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      const Text(
                        'Welcome to FoodnPals',
                        style: TextStyle(
                          fontSize: 24,
                          fontWeight: FontWeight.bold,
                          color: Colors.white,
                        ),
                      ),
                      const SizedBox(height: 4),
                      const Text(
                        'Restaurant Employee App',
                        style: TextStyle(
                          fontSize: 18,
                          color: Colors.white,
                        ),
                      ),
                      const SizedBox(height: 8),
                      Text(
                        'Logged in as: ${widget.staffData['first_name']} ${widget.staffData['last_name']}',
                        style: const TextStyle(
                          fontSize: 14,
                          color: Colors.white70,
                        ),
                      ),
                    ],
                  ),
                ),
              ),
              const SizedBox(height: 24),

              // Tables Section
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  Text(
                    'Tables (${_tables.length})',
                    style: Theme.of(context).textTheme.headlineSmall?.copyWith(
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                  Tooltip(
                    message: 'Double-tap a table to toggle its status',
                    child: Icon(
                      Icons.help_outline,
                      color: Colors.grey[600],
                      size: 20,
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 12),
              Row(
                children: [
                  Expanded(
                    child: OutlinedButton.icon(
                      onPressed: _bulkUpdatingTables || _tables.isEmpty
                          ? null
                          : _setAllTablesReserved,
                      icon: _bulkTableAction == 1
                          ? SizedBox(
                              width: 18,
                              height: 18,
                              child: CircularProgressIndicator(
                                strokeWidth: 2,
                                color: Colors.red[700],
                              ),
                            )
                          : Icon(Icons.event_seat, size: 18, color: Colors.red[800]),
                      label: const Text('Reserve All'),
                      style: OutlinedButton.styleFrom(
                        foregroundColor: Colors.red[800],
                        side: BorderSide(color: Colors.red[400]!),
                        padding: const EdgeInsets.symmetric(vertical: 12),
                      ),
                    ),
                  ),
                  const SizedBox(width: 10),
                  Expanded(
                    child: OutlinedButton.icon(
                      onPressed: _bulkUpdatingTables || _tables.isEmpty
                          ? null
                          : _setAllTablesAvailable,
                      icon: _bulkTableAction == 2
                          ? const SizedBox(
                              width: 18,
                              height: 18,
                              child: CircularProgressIndicator(
                                strokeWidth: 2,
                                valueColor: AlwaysStoppedAnimation<Color>(Color(0xFF4CBB17)),
                              ),
                            )
                          : const Icon(Icons.event_seat_outlined, size: 18),
                      label: const Text('Available All'),
                      style: OutlinedButton.styleFrom(
                        foregroundColor: const Color(0xFF4CBB17),
                        side: const BorderSide(color: Color(0xFF4CBB17)),
                        padding: const EdgeInsets.symmetric(vertical: 12),
                      ),
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 12),
              Wrap(
                spacing: 8,
                runSpacing: 8,
                children: _tables.asMap().entries.map((entry) {
                  final index = entry.key;
                  final table = entry.value;
                  
                  return SizedBox(
                    width: (MediaQuery.of(context).size.width - 48) / 3, // Account for padding and spacing
                    height: (MediaQuery.of(context).size.width - 48) / 3, // Make it square by using same width and height
                    child: GestureDetector(
                      onDoubleTap: _bulkUpdatingTables ? null : () => _toggleTableStatus(index),
                      child: Card(
                        margin: EdgeInsets.zero, // Remove default margin
                        elevation: 4,
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(16),
                        ),
                        color: table.isOccupied 
                            ? Colors.red[400] 
                            : const Color(0xFF4CBB17),
                        child: Container(
                          decoration: BoxDecoration(
                            borderRadius: BorderRadius.circular(16),
                            border: Border.all(
                              color: table.isOccupied 
                                  ? Colors.red[700]! 
                                  : const Color(0xFF45A534),
                              width: 2,
                            ),
                          ),
                          child: Column(
                            mainAxisAlignment: MainAxisAlignment.center,
                            mainAxisSize: MainAxisSize.min,
                            children: [
                              Icon(
                                table.isOccupied 
                                    ? Icons.event_seat 
                                    : Icons.event_seat_outlined,
                                color: Colors.white,
                                size: 18,
                              ),
                              const SizedBox(height: 3),
                              Flexible(
                                child: Text(
                                  'Table ${table.number}',
                                  style: const TextStyle(
                                    color: Colors.white,
                                    fontWeight: FontWeight.bold,
                                    fontSize: 11,
                                  ),
                                  textAlign: TextAlign.center,
                                  maxLines: 1,
                                  overflow: TextOverflow.ellipsis,
                                ),
                              ),
                              const SizedBox(height: 2),
                              Flexible(
                                child: Text(
                                  table.isOccupied ? 'Reserved' : 'Available',
                                  style: const TextStyle(
                                    color: Colors.white,
                                    fontSize: 8,
                                  ),
                                  textAlign: TextAlign.center,
                                  maxLines: 1,
                                  overflow: TextOverflow.ellipsis,
                                ),
                              ),
                              if (table.capacity > 0) ...[
                                const SizedBox(height: 2),
                                Flexible(
                                  child: Text(
                                    '${table.capacity} seats',
                                    style: const TextStyle(
                                      color: Colors.white70,
                                      fontSize: 6,
                                    ),
                                    textAlign: TextAlign.center,
                                    maxLines: 1,
                                    overflow: TextOverflow.ellipsis,
                                  ),
                                ),
                              ],
                            ],
                          ),
                        ),
                      ),
                    ),
                  );
                }).toList(),
              ),
              const SizedBox(height: 20), // Reduced from 40 to prevent overflow

              // QR Code Scanner Button
              Card(
                elevation: 2,
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(12),
                ),
                child: Container(
                  width: double.infinity,
                  padding: const EdgeInsets.all(16),
                  child: Column(
                    children: [
                      Row(
                        children: [
                          Icon(
                            Icons.qr_code_scanner,
                            color: const Color(0xFF4CBB17),
                            size: 24,
                          ),
                          const SizedBox(width: 12),
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                const Text(
                                  'Complete Booking via QR Code',
                                  style: TextStyle(
                                    fontSize: 16,
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                const SizedBox(height: 4),
                                Text(
                                  'Scan QR code to mark booking as completed',
                                  style: TextStyle(
                                    fontSize: 14,
                                    color: Colors.grey[600],
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(height: 12),
                      SizedBox(
                        width: double.infinity,
                        child: ElevatedButton.icon(
                          onPressed: _openQRScanner,
                          icon: const Icon(Icons.qr_code_scanner),
                          label: const Text('Scan QR Code'),
                          style: ElevatedButton.styleFrom(
                            backgroundColor: const Color(0xFF4CBB17),
                            foregroundColor: Colors.white,
                            padding: const EdgeInsets.symmetric(vertical: 12),
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(8),
                            ),
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
              ),
              const SizedBox(height: 20),

              // Active Bookings Section
              Text(
                'Today\'s Bookings',
                style: Theme.of(context).textTheme.headlineSmall?.copyWith(
                  fontWeight: FontWeight.bold,
                ),
              ),
              const SizedBox(height: 12),
              
              // Status Tabs
              if (_statusTabs.isNotEmpty)
                SingleChildScrollView(
                  scrollDirection: Axis.horizontal,
                  child: Row(
                    children: _statusTabs.map((statusTab) {
                      final statusKey = statusTab['key'] as String;
                      final statusLabel = statusTab['label'] as String;
                      final count = _getStatusCount(statusKey);
                      final isSelected = _selectedReservationStatus == statusKey;
                      
                      return Padding(
                        padding: const EdgeInsets.only(right: 8),
                        child: ChoiceChip(
                          label: Text('$statusLabel ($count)'),
                          selected: isSelected,
                          onSelected: (selected) {
                            if (selected) {
                              setState(() {
                                _selectedReservationStatus = statusKey;
                              });
                            }
                          },
                          selectedColor: const Color(0xFF4CBB17),
                          labelStyle: TextStyle(
                            color: isSelected ? Colors.white : Colors.black,
                            fontWeight: isSelected ? FontWeight.bold : FontWeight.normal,
                          ),
                        ),
                      );
                    }).toList(),
                  ),
                ),
              const SizedBox(height: 12),
              
              if (_filteredReservations.isEmpty)
                Card(
                  child: Padding(
                    padding: const EdgeInsets.all(32),
                    child: Column(
                      children: [
                        Icon(
                          Icons.event_available,
                          size: 64,
                          color: Colors.grey[400],
                        ),
                        const SizedBox(height: 16),
                        Text(
                          _selectedReservationStatus == 'all' 
                              ? 'No bookings for today'
                              : 'No ${_selectedReservationStatus} bookings',
                          style: TextStyle(
                            fontSize: 18,
                            color: Colors.grey[600],
                          ),
                        ),
                      ],
                    ),
                  ),
                )
              else
                ListView.builder(
                  shrinkWrap: true,
                  physics: const NeverScrollableScrollPhysics(),
                  itemCount: _filteredReservations.length,
                  itemBuilder: (context, index) {
                    final reservation = _filteredReservations[index];
                    final miles = _reservationIdToMiles[reservation.reservationId];
                    final statusLower = reservation.status.toLowerCase();
                    final shouldBlink = miles != null && miles < 1.0 && (statusLower == 'accepted' || statusLower == 'pending');
                    return Card(
                      margin: const EdgeInsets.only(bottom: 12),
                      elevation: 2,
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                      child: ListTile(
                        contentPadding: const EdgeInsets.symmetric(
                          horizontal: 16,
                          vertical: 8,
                        ),
                        leading: CircleAvatar(
                          backgroundColor: const Color(0xFF4CBB17),
                          child: Text(
                            reservation.customerName.isNotEmpty 
                                ? reservation.customerName[0].toUpperCase()
                                : '?',
                            style: const TextStyle(
                              color: Colors.white,
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                        ),
                        title: Text(
                          reservation.customerName.isNotEmpty 
                              ? reservation.customerName
                              : 'Unknown Customer',
                          style: const TextStyle(
                            fontWeight: FontWeight.bold,
                            fontSize: 16,
                          ),
                        ),
                        subtitle: Padding(
                          padding: const EdgeInsets.only(top: 4),
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Row(
                                children: [
                                  Icon(
                                    Icons.table_restaurant,
                                    size: 16,
                                    color: Colors.grey[600],
                                  ),
                                  const SizedBox(width: 4),
                                  Text('Table ${reservation.tableNumber}'),
                                  const SizedBox(width: 16),
                                  Icon(
                                    Icons.access_time,
                                    size: 16,
                                    color: Colors.grey[600],
                                  ),
                                  const SizedBox(width: 4),
                                  Text(reservation.time),
                                ],
                              ),
                              const SizedBox(height: 4),
                              Row(
                                children: [
                                  Icon(
                                    Icons.people,
                                    size: 16,
                                    color: Colors.grey[600],
                                  ),
                                  const SizedBox(width: 4),
                                  Text('${reservation.numberOfGuests} guests'),
                                  const SizedBox(width: 16),
                                  Container(
                                    padding: const EdgeInsets.symmetric(
                                      horizontal: 8,
                                      vertical: 2,
                                    ),
                                    decoration: BoxDecoration(
                                      color: reservation.status.toLowerCase() == 'confirmed' 
                                          ? Colors.green[100]
                                          : Colors.orange[100],
                                      borderRadius: BorderRadius.circular(12),
                                    ),
                                    child: Text(
                                      reservation.status.toUpperCase(),
                                      style: TextStyle(
                                        fontSize: 10,
                                        fontWeight: FontWeight.bold,
                                        color: reservation.status.toLowerCase() == 'confirmed' 
                                            ? Colors.green[800]
                                            : Colors.orange[800],
                                      ),
                                    ),
                                  ),
                                ],
                              ),
                              const SizedBox(height: 4),
                              if (miles != null) ...[
                                shouldBlink
                                    ? FadeTransition(
                                        opacity: _blinkAnimation,
                                        child: Row(
                                          children: [
                                            const Icon(Icons.directions_walk, size: 16, color: Colors.red),
                                            const SizedBox(width: 4),
                                            Text(
                                              '${miles.toStringAsFixed(miles < 10 ? 1 : 0)} miles away',
                                              style: const TextStyle(
                                                color: Colors.red,
                                                fontWeight: FontWeight.bold,
                                              ),
                                            ),
                                          ],
                                        ),
                                      )
                                    : Row(
                                        children: [
                                          const Icon(Icons.directions_walk, size: 16, color: Colors.grey),
                                          const SizedBox(width: 4),
                                          Text(
                                            '${miles.toStringAsFixed(miles < 10 ? 1 : 0)} miles away',
                                            style: TextStyle(
                                              color: Colors.grey[700],
                                              fontWeight: FontWeight.w500,
                                            ),
                                          ),
                                        ],
                                      ),
                              ]
                            ],
                          ),
                        ),
                        trailing: IconButton(
                          icon: const Icon(Icons.visibility),
                          onPressed: () {
                            Navigator.of(context).push(
                              MaterialPageRoute(
                                builder: (_) => ReservationDetailScreen(
                                  reservation: reservation,
                                  staffData: widget.staffData,
                                ),
                              ),
                            );
                          },
                        ),
                      ),
                    );
                  },
                ),
              ],
            ),
          ),
        ),
     
      
    );
  }
}

class ReservationDetailScreen extends StatefulWidget {
  final ReservationModel reservation;
  final Map<String, dynamic> staffData;

  const ReservationDetailScreen({
    super.key,
    required this.reservation,
    required this.staffData,
  });

  @override
  State<ReservationDetailScreen> createState() => _ReservationDetailScreenState();
}

class _ReservationDetailScreenState extends State<ReservationDetailScreen> {
  final _formKey = GlobalKey<FormState>();
  late TextEditingController _statusController;
  late TextEditingController _specialRequestsController;
  late TextEditingController _numberOfGuestsController;
  late TextEditingController _detailsController;
  
  List<OrderModel> _orders = [];
  bool _isLoading = true;
  bool _isUpdating = false;
  GoogleMapController? _mapController;
  Set<Marker> _markers = {};
  Set<Polyline> _polylines = {};

  @override
  void initState() {
    super.initState();
    // Capitalize first letter of status
    final status = widget.reservation.status;
    final properCaseStatus = status.isNotEmpty 
        ? status[0].toUpperCase() + status.substring(1).toLowerCase()
        : 'Pending';
    _statusController = TextEditingController(text: properCaseStatus);
    _specialRequestsController = TextEditingController(text: widget.reservation.specialRequests);
    _numberOfGuestsController = TextEditingController(text: widget.reservation.numberOfGuests.toString());
    _detailsController = TextEditingController(text: widget.reservation.details);
    
    _initializeMap();
    _loadOrders();
  }

  // Check if booking is locked (Completed or No Show)
  bool get _isBookingLocked {
    final status = widget.reservation.status.toLowerCase();
    return status == 'completed' || status == 'no show';
  }

  // Check if map should be shown (only for Pending or Accepted status)
  bool get _shouldShowMap {
    final status = widget.reservation.status.toLowerCase();
    return status == 'pending' || status == 'accepted';
  }
  
  void _initializeMap() {
    // Create markers for customer and restaurant locations
    if (widget.reservation.customerLatitude.isNotEmpty && 
        widget.reservation.customerLongitude.isNotEmpty) {
      final customerLat = double.tryParse(widget.reservation.customerLatitude);
      final customerLng = double.tryParse(widget.reservation.customerLongitude);
      
      if (customerLat != null && customerLng != null) {
        _markers.add(
          Marker(
            markerId: const MarkerId('customer'),
            position: LatLng(customerLat, customerLng),
            infoWindow: InfoWindow(
              title: 'Customer Location',
              snippet: widget.reservation.customerName,
            ),
            icon: BitmapDescriptor.defaultMarkerWithHue(BitmapDescriptor.hueRed),
          ),
        );
      }
    }
    
    if (widget.reservation.restaurantLatitude.isNotEmpty && 
        widget.reservation.restaurantLongitude.isNotEmpty) {
      final restaurantLat = double.tryParse(widget.reservation.restaurantLatitude);
      final restaurantLng = double.tryParse(widget.reservation.restaurantLongitude);
      
      if (restaurantLat != null && restaurantLng != null) {
        _markers.add(
          Marker(
            markerId: const MarkerId('restaurant'),
            position: LatLng(restaurantLat, restaurantLng),
            infoWindow: const InfoWindow(
              title: 'Restaurant Location',
              snippet: 'FnP Restaurant',
            ),
            icon: BitmapDescriptor.defaultMarkerWithHue(BitmapDescriptor.hueGreen),
          ),
        );
        
        // Add polyline if both locations exist
        if (_markers.length == 2) {
          final customerMarker = _markers.firstWhere((m) => m.markerId.value == 'customer');
          _polylines.add(
            Polyline(
              polylineId: const PolylineId('route'),
              points: [customerMarker.position, LatLng(restaurantLat, restaurantLng)],
              color: const Color(0xFF4CBB17),
              width: 3,
            ),
          );
        }
      }
    }
  }

  @override
  void dispose() {
    _mapController?.dispose();
    _statusController.dispose();
    _specialRequestsController.dispose();
    _numberOfGuestsController.dispose();
    _detailsController.dispose();
    super.dispose();
  }

  Future<void> _loadOrders() async {
    try {
      final data = await ApiUtils.getReservationOrders(widget.reservation.reservationId);
      setState(() {
        _orders = data.map((order) => OrderModel.fromJson(order)).toList();
      });
    } catch (e) {
      // Fallback to empty orders
      setState(() {
        _orders = [];
      });
    } finally {
      setState(() => _isLoading = false);
    }
  }

  String _formatDateTime(String dateTimeStr) {
    try {
      final dateTime = DateTime.parse(dateTimeStr);
      return '${dateTime.day}/${dateTime.month}/${dateTime.year} ${dateTime.hour.toString().padLeft(2, '0')}:${dateTime.minute.toString().padLeft(2, '0')}';
    } catch (e) {
      return dateTimeStr;
    }
  }

  Widget _buildReadOnlyField(String label, String value, IconData icon) {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Container(
          padding: const EdgeInsets.all(8),
          decoration: BoxDecoration(
            color: const Color(0xFF4CBB17).withOpacity(0.1),
            borderRadius: BorderRadius.circular(8),
          ),
          child: Icon(
            icon,
            color: const Color(0xFF4CBB17),
            size: 20,
          ),
        ),
        const SizedBox(width: 12),
        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                label,
                style: TextStyle(
                  fontSize: 12,
                  color: Colors.grey[600],
                  fontWeight: FontWeight.w500,
                ),
              ),
              const SizedBox(height: 4),
              Text(
                value,
                style: const TextStyle(
                  fontSize: 16,
                  fontWeight: FontWeight.w600,
                  color: Colors.black87,
                ),
              ),
            ],
          ),
        ),
      ],
    );
  }

  Future<void> _updateReservation() async {
    // Prevent updates for locked bookings
    if (_isBookingLocked) {
      SnackBarUtils.showError(context, 'Cannot update ${widget.reservation.status} bookings');
      return;
    }

    if (!_formKey.currentState!.validate()) return;

    setState(() => _isUpdating = true);

    try {
      final success = await ApiUtils.updateReservationStatus(
        reservationId: widget.reservation.reservationId,
        status: _statusController.text,
        specialRequests: _specialRequestsController.text,
        numberOfGuests: int.tryParse(_numberOfGuestsController.text),
        details: _detailsController.text,
      );

      if (success) {
        SnackBarUtils.showSuccess(context, 'Booking updated successfully');
        Navigator.of(context).pop();
      } else {
        throw Exception('Failed to update reservation');
      }
    } catch (e) {
      SnackBarUtils.showError(context, 'Error updating booking: $e');
    } finally {
      setState(() => _isUpdating = false);
    }
  }

  Future<void> _showNoShowConfirmationDialog() async {
    return showDialog<void>(
      context: context,
      barrierDismissible: false,
      builder: (BuildContext context) {
        return AlertDialog(
          title: Row(
            children: [
              Icon(
                Icons.warning_amber_rounded,
                color: Colors.orange[600],
                size: 28,
              ),
              const SizedBox(width: 8),
              const Text('No Show Penalty'),
            ],
          ),
          content: Column(
            mainAxisSize: MainAxisSize.min,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                'Are you sure you want to mark this booking as "No Show"?',
                style: const TextStyle(
                  fontSize: 16,
                  fontWeight: FontWeight.w500,
                ),
              ),
              const SizedBox(height: 16),
              Container(
                padding: const EdgeInsets.all(12),
                decoration: BoxDecoration(
                  color: Colors.red.withOpacity(0.1),
                  borderRadius: BorderRadius.circular(8),
                  border: Border.all(color: Colors.red.withOpacity(0.3)),
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Row(
                      children: [
                        Icon(
                          Icons.attach_money,
                          color: Colors.red[600],
                          size: 20,
                        ),
                        const SizedBox(width: 4),
                        Text(
                          'Penalty Charge: \$25.00',
                          style: TextStyle(
                            fontSize: 16,
                            fontWeight: FontWeight.bold,
                            color: Colors.red[600],
                          ),
                        ),
                      ],
                    ),
                    const SizedBox(height: 4),
                    Text(
                      'The customer will be automatically charged a \$25 penalty fee for not showing up.',
                      style: TextStyle(
                        fontSize: 14,
                        color: Colors.red[700],
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),
          actions: [
            TextButton(
              onPressed: () {
                Navigator.of(context).pop();
                // Reset dropdown to previous value
                _statusController.text = widget.reservation.status;
              },
              child: const Text(
                'Cancel',
                style: TextStyle(color: Colors.grey),
              ),
            ),
            ElevatedButton(
              onPressed: () async {
                Navigator.of(context).pop();
                await _processNoShowPenalty();
              },
              style: ElevatedButton.styleFrom(
                backgroundColor: Colors.red[600],
                foregroundColor: Colors.white,
              ),
              child: const Text('Yes, Charge Penalty'),
            ),
          ],
        );
      },
    );
  }

  Future<void> _processNoShowPenalty() async {
    setState(() => _isUpdating = true);

    try {
      // First, update the reservation status to "No Show"
      final updateSuccess = await ApiUtils.updateReservationStatus(
        reservationId: widget.reservation.reservationId,
        status: 'No Show',
        specialRequests: _specialRequestsController.text,
        numberOfGuests: int.tryParse(_numberOfGuestsController.text),
        details: _detailsController.text,
      );

      if (updateSuccess) {
        // Then charge the penalty
        final chargeResponse = await ApiUtils.chargeNoShowPenalty(
          reservationId: widget.reservation.reservationId,
          customerId: widget.reservation.customerId,
        );

        if (chargeResponse['success'] == true) {
          SnackBarUtils.showSuccess(
            context, 
            'Booking marked as No Show and penalty charged successfully'
          );
          _statusController.text = 'No Show';
        } else {
          // Status was updated but penalty charge failed
          SnackBarUtils.showError(
            context, 
            'Booking marked as No Show, but penalty charge failed: ${chargeResponse['message'] ?? 'Unknown error'}'
          );
          _statusController.text = 'No Show';
        }
      } else {
        throw Exception('Failed to update reservation status');
      }
    } catch (e) {
      SnackBarUtils.showError(context, 'Error processing no show: $e');
    } finally {
      setState(() => _isUpdating = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey[50],
      appBar: AppBar(
        title: Text('Booking #${widget.reservation.reservationId}'),
        backgroundColor: const Color(0xFF4CBB17),
        foregroundColor: Colors.white,
        elevation: 0,
      ),
      body: _isLoading
          ? const Center(
              child: CircularProgressIndicator(
                valueColor: AlwaysStoppedAnimation<Color>(Color(0xFF4CBB17)),
              ),
            )
          : SingleChildScrollView(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // Customer Info Card
                  Card(
                    child: Padding(
                      padding: const EdgeInsets.all(16),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Row(
                            children: [
                              CircleAvatar(
                                backgroundColor: const Color(0xFF4CBB17),
                                child: Text(
                                  widget.reservation.customerName.isNotEmpty 
                                      ? widget.reservation.customerName[0].toUpperCase()
                                      : '?',
                                  style: const TextStyle(
                                    color: Colors.white,
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                              ),
                              const SizedBox(width: 16),
                              Expanded(
                                child: Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    Text(
                                      widget.reservation.customerName.isNotEmpty 
                                          ? widget.reservation.customerName
                                          : 'Unknown Customer',
                                      style: const TextStyle(
                                        fontSize: 18,
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                    if (widget.reservation.phoneNumber.isNotEmpty) ...[
                                      const SizedBox(height: 4),
                                      Text(
                                        widget.reservation.phoneNumber,
                                        style: TextStyle(
                                          color: Colors.grey[600],
                                        ),
                                      ),
                                    ],
                                    if (widget.reservation.email.isNotEmpty) ...[
                                      const SizedBox(height: 2),
                                      Text(
                                        widget.reservation.email,
                                        style: TextStyle(
                                          color: Colors.grey[600],
                                          fontSize: 12,
                                        ),
                                      ),
                                    ],
                                  ],
                                ),
                              ),
                            ],
                          ),
                        ],
                      ),
                    ),
                  ),
                  const SizedBox(height: 16),

                  // Read-only Reservation Info
                  Card(
                    child: Padding(
                      padding: const EdgeInsets.all(16),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          const Text(
                            'Booking Information',
                            style: TextStyle(
                              fontSize: 18,
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                          const SizedBox(height: 16),
                          
                          // Reservation DateTime
                          _buildReadOnlyField(
                            'Booking Date & Time',
                            widget.reservation.reservationDateTime.isNotEmpty
                                ? _formatDateTime(widget.reservation.reservationDateTime)
                                : 'Not set',
                            Icons.calendar_today,
                          ),
                          const SizedBox(height: 12),
                          
                          // Table Number
                          _buildReadOnlyField(
                            'Table Number',
                            'Table ${widget.reservation.tableNumber}',
                            Icons.table_restaurant,
                          ),
                          const SizedBox(height: 12),
                          
                          // Extended Time
                          if (widget.reservation.extendedTime.isNotEmpty) ...[
                            _buildReadOnlyField(
                              'Extended Time',
                              _formatDateTime(widget.reservation.extendedTimeLocal.isNotEmpty 
                                ? widget.reservation.extendedTimeLocal 
                                : widget.reservation.extendedTime),
                              Icons.access_time,
                            ),
                            const SizedBox(height: 12),
                          ],
                          
                          // Extension Reason
                          if (widget.reservation.extensionReason.isNotEmpty) ...[
                            _buildReadOnlyField(
                              'Extension Reason',
                              widget.reservation.extensionReason,
                              Icons.info_outline,
                            ),
                            const SizedBox(height: 12),
                          ],
                          
                          // Details
                          if (widget.reservation.details.isNotEmpty) ...[
                            _buildReadOnlyField(
                              'Details',
                              widget.reservation.details,
                              Icons.description,
                            ),
                          ],
                        ],
                      ),
                    ),
                  ),
                  const SizedBox(height: 16),

                  // Reservation Form
                  Card(
                    child: Padding(
                      padding: const EdgeInsets.all(16),
                      child: Form(
                        key: _formKey,
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            // Header with lock status
                            Row(
                              children: [
                                const Text(
                                  'Update Booking',
                                  style: TextStyle(
                                    fontSize: 18,
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                const Spacer(),
                                if (_isBookingLocked)
                                  Container(
                                    padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                                    decoration: BoxDecoration(
                                      color: Colors.red.withOpacity(0.1),
                                      borderRadius: BorderRadius.circular(12),
                                      border: Border.all(color: Colors.red.withOpacity(0.3)),
                                    ),
                                    child: Row(
                                      mainAxisSize: MainAxisSize.min,
                                      children: [
                                        Icon(
                                          Icons.lock,
                                          size: 16,
                                          color: Colors.red[600],
                                        ),
                                        const SizedBox(width: 4),
                                        Text(
                                          'LOCKED',
                                          style: TextStyle(
                                            fontSize: 12,
                                            fontWeight: FontWeight.bold,
                                            color: Colors.red[600],
                                          ),
                                        ),
                                      ],
                                    ),
                                  ),
                              ],
                            ),
                            const SizedBox(height: 16),
                            
                            if (_isBookingLocked) ...[
                              // Show lock message for completed/no show bookings
                              Container(
                                width: double.infinity,
                                padding: const EdgeInsets.all(16),
                                decoration: BoxDecoration(
                                  color: Colors.orange.withOpacity(0.1),
                                  borderRadius: BorderRadius.circular(8),
                                  border: Border.all(color: Colors.orange.withOpacity(0.3)),
                                ),
                                child: Column(
                                  children: [
                                    Icon(
                                      Icons.info_outline,
                                      color: Colors.orange[600],
                                      size: 24,
                                    ),
                                    const SizedBox(height: 8),
                                    Text(
                                      'This booking is ${widget.reservation.status} and cannot be edited.',
                                      style: TextStyle(
                                        color: Colors.orange[800],
                                        fontWeight: FontWeight.w500,
                                      ),
                                      textAlign: TextAlign.center,
                                    ),
                                    const SizedBox(height: 4),
                                    Text(
                                      'Only viewing and map options are available.',
                                      style: TextStyle(
                                        color: Colors.orange[600],
                                        fontSize: 12,
                                      ),
                                      textAlign: TextAlign.center,
                                    ),
                                  ],
                                ),
                              ),
                            ] else ...[
                              // Show full form for editable bookings
                              // Status Dropdown
                              DropdownButtonFormField<String>(
                                value: _statusController.text,
                                decoration: const InputDecoration(
                                  labelText: 'Status',
                                  border: OutlineInputBorder(),
                                ),
                                items: const [
                                  DropdownMenuItem(value: 'Pending', child: Text('Pending')),
                                  DropdownMenuItem(value: 'Accepted', child: Text('Accepted')),
                                  DropdownMenuItem(value: 'Denied', child: Text('Denied')),
                                  DropdownMenuItem(value: 'Completed', child: Text('Completed')),
                                  DropdownMenuItem(value: 'Cancelled', child: Text('Cancelled')),
                                  DropdownMenuItem(value: 'Expired', child: Text('Expired')),
                                  DropdownMenuItem(value: 'No Show', child: Text('No Show')),
                                ],
                                onChanged: (value) {
                                  if (value == 'No Show') {
                                    _showNoShowConfirmationDialog();
                                  } else {
                                    _statusController.text = value ?? 'Pending';
                                  }
                                },
                              ),
                              const SizedBox(height: 16),
                              
                              // Number of Guests
                              TextFormField(
                                controller: _numberOfGuestsController,
                                decoration: const InputDecoration(
                                  labelText: 'Number of Guests',
                                  border: OutlineInputBorder(),
                                ),
                                keyboardType: TextInputType.number,
                                validator: (value) {
                                  if (value == null || value.isEmpty) {
                                    return 'Please enter number of guests';
                                  }
                                  if (int.tryParse(value) == null) {
                                    return 'Please enter a valid number';
                                  }
                                  return null;
                                },
                              ),
                              const SizedBox(height: 16),
                              
                              // Special Requests
                              TextFormField(
                                controller: _specialRequestsController,
                                decoration: const InputDecoration(
                                  labelText: 'Special Requests',
                                  border: OutlineInputBorder(),
                                ),
                                maxLines: 3,
                              ),
                              const SizedBox(height: 16),
                              
                              // Details
                              TextFormField(
                                controller: _detailsController,
                                decoration: const InputDecoration(
                                  labelText: 'Additional Details',
                                  border: OutlineInputBorder(),
                                ),
                                maxLines: 3,
                              ),
                              const SizedBox(height: 24),
                              
                              // Update Button
                              SizedBox(
                                width: double.infinity,
                                child: ElevatedButton(
                                  onPressed: _isUpdating ? null : _updateReservation,
                                  style: ElevatedButton.styleFrom(
                                    backgroundColor: const Color(0xFF4CBB17),
                                    padding: const EdgeInsets.symmetric(vertical: 16),
                                  ),
                                  child: _isUpdating
                                      ? const SizedBox(
                                          height: 20,
                                          width: 20,
                                          child: CircularProgressIndicator(
                                            strokeWidth: 2,
                                            valueColor: AlwaysStoppedAnimation<Color>(Colors.white),
                                          ),
                                        )
                                    : const Text(
                                        'Update Booking',
                                        style: TextStyle(
                                          fontSize: 16,
                                          fontWeight: FontWeight.bold,
                                        ),
                                      ),
                                ),
                              ),
                            ],
                          ],
                        ),
                      ),
                    ),
                  ),
                  const SizedBox(height: 16),

                  // Map Section - Only show for Pending or Accepted status
                  if (_shouldShowMap)
                    Card(
                      clipBehavior: Clip.antiAlias,
                      child: SizedBox(
                        height: 250,
                        width: double.infinity,
                        child: _markers.isEmpty
                            ? Container(
                                decoration: BoxDecoration(
                                  color: Colors.grey[200],
                                ),
                                child: const Center(
                                  child: Column(
                                    mainAxisAlignment: MainAxisAlignment.center,
                                    children: [
                                      Icon(
                                        Icons.location_off,
                                        size: 48,
                                        color: Colors.grey,
                                      ),
                                      SizedBox(height: 8),
                                      Text(
                                        'Location data not available',
                                        style: TextStyle(
                                          fontSize: 14,
                                          color: Colors.grey,
                                        ),
                                      ),
                                    ],
                                  ),
                                ),
                              )
                            : GoogleMap(
                                initialCameraPosition: CameraPosition(
                                  target: _markers.first.position,
                                  zoom: 13,
                                ),
                                markers: _markers,
                                polylines: _polylines,
                                mapType: MapType.normal,
                                myLocationButtonEnabled: false,
                                zoomControlsEnabled: true,
                                onMapCreated: (GoogleMapController controller) {
                                  _mapController = controller;
                                  // Fit bounds to show both markers
                                  if (_markers.length == 2) {
                                    final bounds = LatLngBounds(
                                      southwest: LatLng(
                                        _markers.map((m) => m.position.latitude).reduce((a, b) => a < b ? a : b),
                                        _markers.map((m) => m.position.longitude).reduce((a, b) => a < b ? a : b),
                                      ),
                                      northeast: LatLng(
                                        _markers.map((m) => m.position.latitude).reduce((a, b) => a > b ? a : b),
                                        _markers.map((m) => m.position.longitude).reduce((a, b) => a > b ? a : b),
                                      ),
                                    );
                                    controller.animateCamera(CameraUpdate.newLatLngBounds(bounds, 50));
                                  }
                                },
                              ),
                      ),
                    ),
                  const SizedBox(height: 16),

                  // Orders Section
                  Text(
                    'Orders (${_orders.length})',
                    style: Theme.of(context).textTheme.headlineSmall?.copyWith(
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                  const SizedBox(height: 12),
                  
                  if (_orders.isEmpty)
                    Card(
                      child: Padding(
                        padding: const EdgeInsets.all(32),
                        child: Column(
                          children: [
                            Icon(
                              Icons.shopping_cart_outlined,
                              size: 64,
                              color: Colors.grey[400],
                            ),
                            const SizedBox(height: 16),
                            Text(
                              'No orders for this booking',
                              style: TextStyle(
                                fontSize: 18,
                                color: Colors.grey[600],
                              ),
                            ),
                          ],
                        ),
                      ),
                    )
                  else
                    ...(_orders.map((order) => Card(
                      margin: const EdgeInsets.only(bottom: 12),
                      child: Padding(
                        padding: const EdgeInsets.all(16),
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Row(
                              mainAxisAlignment: MainAxisAlignment.spaceBetween,
                              children: [
                                Text(
                                  'Order #${order.orderId}',
                                  style: const TextStyle(
                                    fontSize: 16,
                                    fontWeight: FontWeight.bold,
                                  ),
                                ),
                                Container(
                                  padding: const EdgeInsets.symmetric(
                                    horizontal: 8,
                                    vertical: 4,
                                  ),
                                  decoration: BoxDecoration(
                                    color: order.status == 'completed' 
                                        ? Colors.green[100]
                                        : Colors.orange[100],
                                    borderRadius: BorderRadius.circular(12),
                                  ),
                                  child: Text(
                                    order.status.toUpperCase(),
                                    style: TextStyle(
                                      fontSize: 10,
                                      fontWeight: FontWeight.bold,
                                      color: order.status == 'completed' 
                                          ? Colors.green[800]
                                          : Colors.orange[800],
                                    ),
                                  ),
                                ),
                              ],
                            ),
                            const SizedBox(height: 8),
                            Text(
                              'Total: \$${order.totalAmount.toStringAsFixed(2)}',
                              style: const TextStyle(
                                fontSize: 14,
                                fontWeight: FontWeight.bold,
                                color: Color(0xFF4CBB17),
                              ),
                            ),
                            const SizedBox(height: 8),
                            ...order.orderDetails.map((detail) => Padding(
                              padding: const EdgeInsets.symmetric(vertical: 2),
                              child: Row(
                                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                children: [
                                  Expanded(
                                    child: Text(
                                      '${detail.quantity}x ${detail.itemName}',
                                      style: const TextStyle(fontSize: 14),
                                    ),
                                  ),
                                  Text(
                                    '\$${detail.subtotal.toStringAsFixed(2)}',
                                    style: const TextStyle(
                                      fontSize: 14,
                                      fontWeight: FontWeight.bold,
                                    ),
                                  ),
                                ],
                              ),
                            )),
                          ],
                        ),
                      ),
                    ))),
                ],
              ),
            ),
    );
  }
}
