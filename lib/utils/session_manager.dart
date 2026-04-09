import 'package:shared_preferences/shared_preferences.dart';

class SessionManager {
  static const String _staffIdKey = 'staff_id';
  static const String _restaurantIdKey = 'restaurant_id';
  static const String _firstNameKey = 'first_name';
  static const String _lastNameKey = 'last_name';
  static const String _emailKey = 'email';
  static const String _userTypeKey = 'user_type';
  static const String _designationKey = 'designation';
  static const String _tokenKey = 'token';
  static const String _isLoggedInKey = 'is_logged_in';

  // Save user session data
  static Future<void> saveSession(Map<String, dynamic> staffData) async {
    final prefs = await SharedPreferences.getInstance();
    
    await prefs.setBool(_isLoggedInKey, true);
    await prefs.setInt(_staffIdKey, staffData['staff_id']);
    await prefs.setInt(_restaurantIdKey, staffData['restaurant_id']);
    await prefs.setString(_firstNameKey, staffData['first_name']);
    await prefs.setString(_lastNameKey, staffData['last_name']);
    await prefs.setString(_emailKey, staffData['email']);
    await prefs.setString(_userTypeKey, staffData['user_type']);
    await prefs.setString(_designationKey, staffData['designation']);
    await prefs.setString(_tokenKey, staffData['token']);
  }

  // Get user session data
  static Future<Map<String, dynamic>?> getSession() async {
    final prefs = await SharedPreferences.getInstance();
    
    final isLoggedIn = prefs.getBool(_isLoggedInKey) ?? false;
    if (!isLoggedIn) return null;

    return {
      'staff_id': prefs.getInt(_staffIdKey),
      'restaurant_id': prefs.getInt(_restaurantIdKey),
      'first_name': prefs.getString(_firstNameKey),
      'last_name': prefs.getString(_lastNameKey),
      'email': prefs.getString(_emailKey),
      'user_type': prefs.getString(_userTypeKey),
      'designation': prefs.getString(_designationKey),
      'token': prefs.getString(_tokenKey),
    };
  }

  // Check if user is logged in
  static Future<bool> isLoggedIn() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getBool(_isLoggedInKey) ?? false;
  }

  // Clear session data (logout)
  static Future<void> clearSession() async {
    final prefs = await SharedPreferences.getInstance();
    
    await prefs.remove(_isLoggedInKey);
    await prefs.remove(_staffIdKey);
    await prefs.remove(_restaurantIdKey);
    await prefs.remove(_firstNameKey);
    await prefs.remove(_lastNameKey);
    await prefs.remove(_emailKey);
    await prefs.remove(_userTypeKey);
    await prefs.remove(_designationKey);
    await prefs.remove(_tokenKey);
  }

  // Update specific session data
  static Future<void> updateSessionData(String key, dynamic value) async {
    final prefs = await SharedPreferences.getInstance();
    
    if (value is String) {
      await prefs.setString(key, value);
    } else if (value is int) {
      await prefs.setInt(key, value);
    } else if (value is bool) {
      await prefs.setBool(key, value);
    }
  }
}
