# Building the Installable Package

## Quick Start

To build the installable Joomla package:

```bash
chmod +x build.sh
./build.sh
```

This will create `build/com_advform_1.0.0.zip` which can be directly installed in Joomla.

## What the Build Script Does

The build script (`build.sh`) performs the following steps:

1. **Cleans previous builds** - Removes any existing build directory
2. **Creates package structure** - Sets up the proper Joomla installation structure
3. **Copies manifest file** - Places `advform.xml` at the root of the package (required by Joomla)
4. **Copies administrator files** - Includes all backend component files
5. **Copies site files** - Includes all frontend component files
6. **Creates ZIP package** - Packages everything into `com_advform_1.0.0.zip`

## Package Structure

The generated ZIP file has this structure:

```
com_advform_1.0.0.zip
├── advform.xml (manifest file - MUST be at root)
├── administrator/
│   └── components/
│       └── com_advform/
│           ├── access.xml
│           ├── config.xml
│           ├── forms/
│           ├── language/
│           ├── services/
│           ├── sql/
│           ├── src/
│           └── tmpl/
└── components/
    └── com_advform/
        └── src/
```

## Installing in Joomla

Once the package is built:

1. Log into your **Joomla Administrator** panel (typically `https://yoursite.com/administrator`)
2. Navigate to **System** → **Install** → **Extensions**
3. Click on the **Upload Package File** tab
4. Click **Browse** and select `build/com_advform_1.0.0.zip`
5. Click **Upload & Install**
6. Wait for the success message: "Installation of the component was successful"
7. Access the component at **Components** → **Advanced Form**

## Requirements

- Joomla 5.0 or higher
- PHP 8.1 or higher
- MySQL 5.7+ or MariaDB 10.3+
- `zip` command (for building the package)

## Troubleshooting

### Build script fails

Make sure the script is executable:
```bash
chmod +x build.sh
```

### ZIP command not found

Install zip utility:
```bash
# Ubuntu/Debian
sudo apt-get install zip

# macOS (usually pre-installed)
brew install zip

# CentOS/RHEL
sudo yum install zip
```

### Installation fails in Joomla

Check that:
1. The `advform.xml` manifest is at the root of the ZIP (not in a subdirectory)
2. Your Joomla version is 5.0 or higher
3. PHP version is 8.1 or higher
4. File upload limits in PHP allow the ZIP file size

## Manual Installation (Development Only)

For development purposes, you can manually copy files instead of using the ZIP:

```bash
# Copy administrator files
cp -r administrator/components/com_advform /path/to/joomla/administrator/components/

# Copy site files
cp -r components/com_advform /path/to/joomla/components/

# Install database tables
mysql -u username -p database_name < administrator/components/com_advform/sql/install.mysql.utf8.sql
```

**Note:** Manual installation requires registering the extension in Joomla's `#__extensions` table. Using the ZIP installer is strongly recommended.

## For Developers

### Modifying the Component

1. Make your changes in the `administrator/components/com_advform/` or `components/com_advform/` directories
2. Test your changes in a development Joomla installation
3. Run `./build.sh` to create a new package
4. Install the new package in Joomla (it will upgrade the existing installation)

### Version Management

To update the version:

1. Edit `advform.xml` and update the `<version>` tag
2. Edit `build.sh` and update the `VERSION` variable
3. Run `./build.sh` to create the new versioned package

## Distribution

The generated `build/com_advform_1.0.0.zip` file is the distributable package that can be:

- Uploaded to GitHub Releases
- Shared with users for installation
- Submitted to the Joomla Extensions Directory (JED)
- Distributed through your own channels

The package is completely self-contained and ready for installation on any compatible Joomla site.
