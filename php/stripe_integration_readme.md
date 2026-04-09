# Stripe Integration for Reservation Guarantee

This feature adds Stripe payment method collection during the booking process to guarantee reservations. The system will save the customer's card details, which can be used to charge a $30 fee in case of a no-show.

## Files Added/Modified

1. `save_payment_method.php` - Handles saving the Stripe payment method to the database
2. `payment_setup.php` - UI for collecting payment method details
3. `finalize_reservation.php` - Creates the reservation after payment method is saved
4. `process_reservation.php` - Modified to store reservation data in session instead of creating immediately
5. `Profile.php` - Modified to add payment info notification
6. `setup_stripe_table.php` - Creates the StripeCustomers table
7. `update_reservations_table.php` - Adds SpecialInstructions column to reservations table

## Setup Instructions

1. Run the database setup scripts:
   ```
   php setup_stripe_table.php
   php update_reservations_table.php
   ```

2. Ensure Stripe API keys are correctly set in the relevant files:
   - `save_payment_method.php` (Server-side key)
   - `payment_setup.php` (Client-side publishable key)

3. Test the booking flow to ensure payment methods are being collected and saved correctly.

## How It Works

1. User selects a table and enters reservation details
2. User is shown information about the payment guarantee policy
3. User is redirected to payment method setup page
4. User enters their card details (no charge is made at this time)
5. Card details are securely saved to the StripeCustomers table
6. Reservation is created and linked to the saved payment method
7. User is redirected to the confirmation page

## Charging for No-Shows

The implementation for charging $30 for no-shows is not included in this integration. It will be implemented separately. The current integration only saves the payment method for future use.

## Security Considerations

- Stripe API keys should be kept secure and never exposed in client-side code
- Only the payment method ID and last 4 digits of the card are stored in the database
- Full card details are stored securely by Stripe, not in the application database 