import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:mobile_scanner/mobile_scanner.dart';
import 'package:permission_handler/permission_handler.dart';

class QRCodeScannerScreen extends StatefulWidget {
  final Function(String) onQRCodeScanned;
  const QRCodeScannerScreen({super.key, required this.onQRCodeScanned});

  @override
  State<QRCodeScannerScreen> createState() => _QRCodeScannerScreenState();
}

class _QRCodeScannerScreenState extends State<QRCodeScannerScreen> {
  late MobileScannerController controller;
  bool torchOn = false;
  bool hasScanned = false;
  bool cameraReady = false;
  String? lastCode;

  @override
  void initState() {
    super.initState();
    print('🔍 initState() → Starting QRCodeScannerScreen');
    print('🔍 Callback function: ${widget.onQRCodeScanned}');
    controller = MobileScannerController(
      facing: CameraFacing.back,
      detectionSpeed: DetectionSpeed.normal,
      formats: [BarcodeFormat.qrCode],
    );

    _initCamera();
  }

  Future<void> _initCamera() async {
    print('🔍 Requesting camera permission...');
    final status = await Permission.camera.request();
    print('📋 Camera permission status: $status');

    if (!status.isGranted) {
      print('❌ Camera permission denied');
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Camera permission required')),
      );
      Navigator.pop(context);
      return;
    }

    print('✅ Camera permission granted');
    
    // Wait for camera to actually start
    try {
      await controller.start();
      print('✅ Camera controller started successfully');
      await Future.delayed(const Duration(milliseconds: 1000)); // Give camera time to initialize
      setState(() => cameraReady = true);
      print('✅ Camera is now ready for scanning');
    } catch (e) {
      print('❌ Failed to start camera: $e');
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Failed to start camera: $e')),
      );
    }
  }

  void _onDetect(BarcodeCapture capture) {
    print('🔍 onDetect() triggered → cameraReady=$cameraReady');
    print('🔍 Capture timestamp: ${DateTime.now()}');
    print('🔍 Barcodes count: ${capture.barcodes.length}');

    if (!cameraReady) {
      print('⚠️ Camera not ready yet, ignoring detection');
      return;
    }

    try {
      if (capture.barcodes.isEmpty) {
        print('⚠️ onDetect() called but no barcodes found');
        return;
      }

      final barcode = capture.barcodes.first;
      print('📦 Barcode detected → format: ${barcode.format}, value: ${barcode.rawValue}');
      print('📦 Barcode type: ${barcode.type}');

      final code = barcode.rawValue;
      if (code != null && code.isNotEmpty) {
        lastCode = code;
        print('✅ Valid QR detected: $code');
        print('✅ Calling onQRCodeScanned callback...');
        HapticFeedback.mediumImpact();
        try {
          Navigator.pop(context);
          print('✅ Navigator.pop called');
          // Call callback after closing the scanner screen
          widget.onQRCodeScanned(code);
          print('✅ Callback executed successfully');
        } catch (e) {
          print('❌ Error in QR detection callback: $e');
        }
      } else {
        print('⚠️ QR code empty or null');
      }
    } catch (e, st) {
      print('❌ Exception in _onDetect: $e');
      print(st);
    }
  }

  @override
  void dispose() {
    print('🧹 dispose() → Releasing camera and controller');
    controller.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    print('🔍 Building QRCodeScannerScreen → cameraReady=$cameraReady');

    return Scaffold(
      backgroundColor: Colors.black,
      appBar: AppBar(
        title: const Text('Scan QR Code'),
        backgroundColor: Colors.black,
        foregroundColor: Colors.white,
        actions: [
          IconButton(
            icon: Icon(
              torchOn ? Icons.flash_on : Icons.flash_off,
              color: torchOn ? Colors.yellow : Colors.white,
            ),
            onPressed: () {
              print('💡 Toggling torch...');
              try {
                controller.toggleTorch();
                setState(() => torchOn = !torchOn);
              } catch (e) {
                print('❌ Torch toggle failed: $e');
              }
            },
          ),
        ],
      ),
      body: Stack(
        alignment: Alignment.center,
        children: [
          MobileScanner(
            controller: controller,
            onDetect: _onDetect,
            errorBuilder: (context, error, child) {
              print('❌ MobileScanner error: $error');
              return Container(
                color: Colors.black,
                alignment: Alignment.center,
                child: Text(
                  'Camera error: $error',
                  style: const TextStyle(color: Colors.redAccent),
                  textAlign: TextAlign.center,
                ),
              );
            },
          ),
          // Green Frame
          Container(
            width: 280,
            height: 280,
            decoration: BoxDecoration(
              border: Border.all(color: Colors.green, width: 3),
              borderRadius: BorderRadius.circular(16),
            ),
          ),
          // Status Text
          Positioned(
            bottom: 60,
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                Text(
                  cameraReady
                      ? 'Align QR code within the frame'
                      : 'Camera initializing...',
                  style: TextStyle(
                    color: cameraReady ? Colors.white : Colors.orange,
                    fontSize: 18,
                    fontWeight: FontWeight.bold,
                  ),
                ),
                if (cameraReady) ...[
                  const SizedBox(height: 8),
                  const Text(
                    'Ready to scan!',
                    style: TextStyle(
                      color: Colors.green,
                      fontSize: 14,
                    ),
                  ),
                  const SizedBox(height: 16),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      ElevatedButton.icon(
                        onPressed: () {
                          print('🧪 Test QR button pressed');
                          print('🧪 Calling onQRCodeScanned callback...');
                          try {
                            Navigator.pop(context);
                            print('🧪 Navigator.pop called');
                            // Call callback after closing the scanner screen
                            widget.onQRCodeScanned('https://foodnpals.com/admin/QRCode.php?ID=362');
                            print('🧪 Callback executed successfully');
                          } catch (e) {
                            print('❌ Error in Test QR button: $e');
                          }
                        },
                        icon: const Icon(Icons.qr_code),
                        label: const Text('Test QR'),
                        style: ElevatedButton.styleFrom(
                          backgroundColor: Colors.orange,
                          foregroundColor: Colors.white,
                        ),
                      ),
                      const SizedBox(width: 16),
                      ElevatedButton.icon(
                        onPressed: () {
                          print('🔄 Restart camera');
                          setState(() {
                            cameraReady = false;
                          });
                          _initCamera();
                        },
                        icon: const Icon(Icons.refresh),
                        label: const Text('Restart'),
                        style: ElevatedButton.styleFrom(
                          backgroundColor: Colors.blue,
                          foregroundColor: Colors.white,
                        ),
                      ),
                    ],
                  ),
                ],
              ],
            ),
          ),
        ],
      ),
    );
  }
}
