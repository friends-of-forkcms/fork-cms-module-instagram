# Execute these queries to uninstall the module (used for development)

-- Drop module tables
DROP TABLE IF EXISTS instagram_users;

-- Remove from backend navigation
DELETE FROM backend_navigation WHERE label = 'Instagram';
DELETE FROM backend_navigation WHERE url = '%dealer%';

-- Remove from groups_rights
DELETE FROM groups_rights_actions WHERE module = 'Instagram';
DELETE FROM groups_rights_modules WHERE module = 'Instagram';

-- Remove from locale
DELETE FROM locale WHERE module = 'Instagram';
DELETE FROM locale WHERE module = 'Core' AND name = 'instagram%';

-- Remove from modules
DELETE FROM modules WHERE name = 'Instagram';
DELETE FROM modules_extras WHERE module = 'Instagram';
DELETE FROM modules_settings WHERE module = 'Instagram';

-- Remove from search
DELETE FROM search_index WHERE module = 'Instagram';

-- Remove from Meta
DELETE FROM meta WHERE keywords = '%instagram%';
