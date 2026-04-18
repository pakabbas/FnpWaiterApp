import 'package:http/http.dart' as http;
import 'dart:convert';

class ApiUtils {
  static const String baseUrl = 'https://foodnpals.com/api';
  
  // Generic HTTP POST method
  static Future<Map<String, dynamic>> postRequest({
    required String endpoint,
    required Map<String, dynamic> body,
    Map<String, String>? headers,
  }) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/$endpoint'),
        headers: headers ?? {'Content-Type': 'application/json'},
        body: json.encode(body),
      );

      if (response.statusCode == 200) {
        return json.decode(response.body);
      } else {
        throw Exception('HTTP ${response.statusCode}: ${response.body}');
      }
    } catch (e) {
      throw Exception('API request failed: $e');
    }
  }

  // Generic HTTP GET method
  static Future<Map<String, dynamic>> getRequest({
    required String endpoint,
    Map<String, String>? queryParams,
  }) async {
    try {
      final uri = Uri.parse('$baseUrl/$endpoint');
      final uriWithParams = queryParams != null 
          ? uri.replace(queryParameters: queryParams)
          : uri;
          
      final response = await http.get(uriWithParams);

      if (response.statusCode == 200) {
        return json.decode(response.body);
      } else {
        throw Exception('HTTP ${response.statusCode}: ${response.body}');
      }
    } catch (e) {
      throw Exception('API request failed: $e');
    }
  }

  // Update FCM Token
  static Future<bool> updateFCMToken({
    required int staffId,
    required String fcmToken,
  }) async {
    try {
      final response = await postRequest(
        endpoint: 'updateFCMToken.php',
        body: {
          'staff_id': staffId,
          'fcm_token': fcmToken,
        },
      );
      
      return response['success'] == true;
    } catch (e) {
      print('Error updating FCM token: $e');
      return false;
    }
  }

  // Update table status
  static Future<bool> updateTableStatus({
    required int tableId,
    required String status,
  }) async {
    try {
      final response = await postRequest(
        endpoint: 'update_table_status.php',
        body: {
          'table_id': tableId,
          'status': status,
        },
      );
      
      return response['success'] == true;
    } catch (e) {
      print('Error updating table status: $e');
      return false;
    }
  }

  // Update reservation status
  static Future<bool> updateReservationStatus({
    required int reservationId,
    required String status,
    int? tableId,
    int? tableNumber,
    String? specialRequests,
    int? numberOfGuests,
    String? details,
    String? declineReason,
  }) async {
    try {
      final body = {
        'reservation_id': reservationId,
        'status': status,
      };
      
      if (tableId != null) body['table_id'] = tableId;
      if (tableNumber != null) body['table_number'] = tableNumber;
      if (specialRequests != null) body['special_requests'] = specialRequests;
      if (numberOfGuests != null) body['number_of_guests'] = numberOfGuests;
      if (details != null) body['details'] = details;
      if (declineReason != null) body['decline_reason'] = declineReason;

      final response = await postRequest(
        endpoint: 'update_reservation.php',
        body: body,
      );
      
      return response['success'] == true;
    } catch (e) {
      print('Error updating reservation: $e');
      return false;
    }
  }

  // Complete booking from QR
  static Future<Map<String, dynamic>> completeBookingFromQR({
    required String qrUrl,
    required int staffId,
  }) async {
    try {
      final response = await postRequest(
        endpoint: 'complete_booking_from_qr.php',
        body: {
          'qr_url': qrUrl,
          'staff_id': staffId,
        },
      );
      
      return response;
    } catch (e) {
      throw Exception('Failed to complete booking: $e');
    }
  }

  // Get tables
  static Future<List<dynamic>> getTables(int restaurantId) async {
    try {
      final response = await getRequest(
        endpoint: 'get_tables.php',
        queryParams: {'restaurant_id': restaurantId.toString()},
      );
      
      if (response['success'] == true) {
        return response['data'] as List<dynamic>;
      } else {
        throw Exception(response['message'] ?? 'Failed to load tables');
      }
    } catch (e) {
      print('Error loading tables: $e');
      rethrow;
    }
  }

  // Get reservations
  static Future<List<dynamic>> getReservations(int restaurantId) async {
    try {
      final response = await getRequest(
        endpoint: 'get_reservations.php',
        queryParams: {'restaurant_id': restaurantId.toString()},
      );
      
      if (response['success'] == true) {
        return response['data'] as List<dynamic>;
      } else {
        throw Exception(response['message'] ?? 'Failed to load reservations');
      }
    } catch (e) {
      print('Error loading reservations: $e');
      rethrow;
    }
  }

  // Get reservation orders
  static Future<List<dynamic>> getReservationOrders(int reservationId) async {
    try {
      final response = await getRequest(
        endpoint: 'get_reservation_orders.php',
        queryParams: {'reservation_id': reservationId.toString()},
      );
      
      if (response['success'] == true) {
        return response['data'] as List<dynamic>;
      } else {
        throw Exception(response['message'] ?? 'Failed to load orders');
      }
    } catch (e) {
      print('Error loading orders: $e');
      return [];
    }
  }

  // Staff login
  static Future<Map<String, dynamic>> staffLogin({
    required String username,
    required String password,
  }) async {
    try {
      final response = await postRequest(
        endpoint: 'stafflogin.php',
        body: {
          'username': username,
          'password': password,
        },
      );
      
      return response;
    } catch (e) {
      throw Exception('Login failed: $e');
    }
  }

  // Get restaurant timezone
  static Future<Map<String, dynamic>> getRestaurantTimezone(int restaurantId) async {
    try {
      final response = await getRequest(
        endpoint: 'get_restaurant_timezone.php',
        queryParams: {'restaurant_id': restaurantId.toString()},
      );
      
      return response;
    } catch (e) {
      throw Exception('Failed to get restaurant timezone: $e');
    }
  }

  // Charge no show penalty
  static Future<Map<String, dynamic>> chargeNoShowPenalty({
    required int reservationId,
    required int customerId,
  }) async {
    try {
      final response = await postRequest(
        endpoint: 'ChargeNoShow.php',
        body: {
          'reservation_id': reservationId,
          'customer_id': customerId,
        },
      );
      
      return response;
    } catch (e) {
      throw Exception('Failed to charge no show penalty: $e');
    }
  }
}
