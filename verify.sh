#!/bin/bash
# Verification script for com_advform package

PACKAGE_FILE="build/com_advform_1.0.0.zip"
ERRORS=0

echo "=================================="
echo "com_advform Package Verification"
echo "=================================="
echo ""

# Check if package exists
if [ ! -f "$PACKAGE_FILE" ]; then
    echo "❌ ERROR: Package file not found: $PACKAGE_FILE"
    echo "   Run ./build.sh first to create the package"
    exit 1
fi

echo "✅ Package file exists: $PACKAGE_FILE"
echo "   Size: $(du -h $PACKAGE_FILE | cut -f1)"
echo ""

# Test ZIP integrity
echo "Testing ZIP file integrity..."
if unzip -t "$PACKAGE_FILE" > /dev/null 2>&1; then
    echo "✅ ZIP file is valid and not corrupted"
else
    echo "❌ ERROR: ZIP file is corrupted or invalid"
    ERRORS=$((ERRORS + 1))
fi
echo ""

# Check for required files at root
echo "Checking required files..."
if unzip -l "$PACKAGE_FILE" | grep -q "^.*advform\.xml$"; then
    echo "✅ Manifest file (advform.xml) found at root"
else
    echo "❌ ERROR: Manifest file (advform.xml) NOT at root level"
    echo "   This is required for Joomla installation"
    ERRORS=$((ERRORS + 1))
fi
echo ""

# Check for administrator files
echo "Checking administrator component files..."
if unzip -l "$PACKAGE_FILE" | grep -q "administrator/components/com_advform/"; then
    echo "✅ Administrator component files found"
    
    # Check for essential admin files
    ADMIN_FILES=(
        "administrator/components/com_advform/access.xml"
        "administrator/components/com_advform/config.xml"
        "administrator/components/com_advform/sql/install.mysql.utf8.sql"
    )
    
    for file in "${ADMIN_FILES[@]}"; do
        if unzip -l "$PACKAGE_FILE" | grep -q "$file"; then
            echo "   ✅ $file"
        else
            echo "   ❌ MISSING: $file"
            ERRORS=$((ERRORS + 1))
        fi
    done
else
    echo "❌ ERROR: Administrator component files not found"
    ERRORS=$((ERRORS + 1))
fi
echo ""

# Check for site files
echo "Checking site component files..."
if unzip -l "$PACKAGE_FILE" | grep -q "components/com_advform/"; then
    echo "✅ Site component files found"
else
    echo "❌ ERROR: Site component files not found"
    ERRORS=$((ERRORS + 1))
fi
echo ""

# Check file count
FILE_COUNT=$(unzip -l "$PACKAGE_FILE" | grep -E "^\s+[0-9]+" | wc -l)
echo "Package contains $FILE_COUNT files"
echo ""

# Summary
echo "=================================="
echo "Verification Summary"
echo "=================================="
if [ $ERRORS -eq 0 ]; then
    echo "✅ All checks passed!"
    echo "   The package is ready for installation in Joomla"
    echo ""
    echo "To install:"
    echo "1. Log into Joomla Administrator"
    echo "2. Go to System → Install → Extensions"
    echo "3. Upload: $PACKAGE_FILE"
    echo "4. Click 'Upload & Install'"
    exit 0
else
    echo "❌ Found $ERRORS error(s)"
    echo "   Please fix the errors before installing"
    exit 1
fi
