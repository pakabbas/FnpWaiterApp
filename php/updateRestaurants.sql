-- Purpose: Schema update script for `restaurants` table if you choose to persist new address fields separately.
-- Current implementation requires NO schema changes because:
-- - `Address` (existing) continues to store Address Line 1 and Address Line 2 as a single combined string
-- - `City`, `State`, and `PostalCode` already exist

-- OPTIONAL: If you want to store country explicitly
-- ALTER TABLE `restaurants`
--   ADD COLUMN `Country` VARCHAR(64) NULL AFTER `City`;

-- OPTIONAL: If you want to store Address Line 2 separately
-- ALTER TABLE `restaurants`
--   ADD COLUMN `AddressLine2` VARCHAR(255) NULL AFTER `Address`;

-- NOTE: If you add `AddressLine2`, existing data will remain in `Address`. A one-off manual migration would be required
-- to split `Address` into `Address` and `AddressLine2` if desired. This cannot be done safely without custom parsing.


