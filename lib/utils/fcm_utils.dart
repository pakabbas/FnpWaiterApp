import 'package:firebase_messaging/firebase_messaging.dart';
import 'api_utils.dart';

class FCMUtils {
  // Update FCM token for staff
  static Future<void> updateStaffFCMToken(int staffId) async {
    try {
      // Get FCM token
      final messaging = FirebaseMessaging.instance;
      final token = await messaging.getToken();
      
      if (token != null) {
        // Update FCM token in database
        final success = await ApiUtils.updateFCMToken(
          staffId: staffId,
          fcmToken: token,
        );
        
        if (success) {
          print('FCM token updated successfully for staff ID: $staffId');
        } else {
          print('Failed to update FCM token for staff ID: $staffId');
        }
      } else {
        print('Failed to get FCM token');
      }
    } catch (e) {
      print('Error updating FCM token: $e');
    }
  }

  // Setup FCM token refresh listener
  static void setupTokenRefreshListener(int staffId) {
    FirebaseMessaging.instance.onTokenRefresh.listen((newToken) {
      _updateFCMTokenInDatabase(staffId, newToken);
    });
  }

  // Private method to update FCM token in database
  static Future<void> _updateFCMTokenInDatabase(int staffId, String token) async {
    try {
      final success = await ApiUtils.updateFCMToken(
        staffId: staffId,
        fcmToken: token,
      );
      
      if (success) {
        print('FCM token refreshed successfully for staff ID: $staffId');
      } else {
        print('Failed to refresh FCM token for staff ID: $staffId');
      }
    } catch (e) {
      print('Error refreshing FCM token: $e');
    }
  }

  // Request notification permissions
  static Future<void> requestNotificationPermissions() async {
    await FirebaseMessaging.instance.requestPermission(
      alert: true,
      badge: true,
      sound: true,
    );
  }
}
