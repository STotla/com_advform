#!/bin/bash
# Validation script for com_advform component

echo "=========================================="
echo "com_advform Component Validation"
echo "=========================================="
echo ""

# Color codes
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Track overall status
ERRORS=0
WARNINGS=0

# Function to check file exists
check_file() {
    if [ -f "$1" ]; then
        echo -e "${GREEN}✓${NC} Found: $1"
    else
        echo -e "${RED}✗${NC} Missing: $1"
        ((ERRORS++))
    fi
}

# Function to check directory exists
check_dir() {
    if [ -d "$1" ]; then
        echo -e "${GREEN}✓${NC} Found directory: $1"
    else
        echo -e "${RED}✗${NC} Missing directory: $1"
        ((ERRORS++))
    fi
}

# Function to check PHP syntax
check_php_syntax() {
    if php -l "$1" > /dev/null 2>&1; then
        echo -e "${GREEN}✓${NC} PHP syntax valid: $1"
    else
        echo -e "${RED}✗${NC} PHP syntax error: $1"
        ((ERRORS++))
    fi
}

echo "1. Checking Required Directories..."
echo "-----------------------------------"
check_dir "administrator/components/com_advform"
check_dir "administrator/components/com_advform/src"
check_dir "administrator/components/com_advform/forms"
check_dir "administrator/components/com_advform/sql"
check_dir "administrator/components/com_advform/tmpl"
check_dir "components/com_advform"
echo ""

echo "2. Checking Core Files..."
echo "-----------------------------------"
check_file "administrator/components/com_advform/advform.xml"
check_file "administrator/components/com_advform/access.xml"
check_file "administrator/components/com_advform/config.xml"
check_file "administrator/components/com_advform/services/provider.php"
echo ""

echo "3. Checking MVC Files..."
echo "-----------------------------------"
# Controllers
check_file "administrator/components/com_advform/src/Controller/FieldController.php"
check_file "administrator/components/com_advform/src/Controller/FieldsController.php"

# Models
check_file "administrator/components/com_advform/src/Model/FieldModel.php"
check_file "administrator/components/com_advform/src/Model/FieldsModel.php"

# Views
check_file "administrator/components/com_advform/src/View/Field/HtmlView.php"
check_file "administrator/components/com_advform/src/View/Fields/HtmlView.php"

# Table
check_file "administrator/components/com_advform/src/Table/FieldTable.php"

# Extension
check_file "administrator/components/com_advform/src/Extension/AdvformComponent.php"
echo ""

echo "4. Checking Form Files..."
echo "-----------------------------------"
check_file "administrator/components/com_advform/forms/field.xml"
check_file "administrator/components/com_advform/forms/option.xml"
check_file "administrator/components/com_advform/forms/filter_fields.xml"
echo ""

echo "5. Checking Template Files..."
echo "-----------------------------------"
check_file "administrator/components/com_advform/tmpl/fields/default.php"
check_file "administrator/components/com_advform/tmpl/field/edit.php"
echo ""

echo "6. Checking SQL Files..."
echo "-----------------------------------"
check_file "administrator/components/com_advform/sql/install.mysql.utf8.sql"
check_file "administrator/components/com_advform/sql/uninstall.mysql.utf8.sql"
echo ""

echo "7. Checking Language Files..."
echo "-----------------------------------"
check_file "administrator/components/com_advform/language/en-GB/com_advform.ini"
check_file "administrator/components/com_advform/language/en-GB/com_advform.sys.ini"
echo ""

echo "8. Checking PHP Syntax..."
echo "-----------------------------------"
for phpfile in $(find administrator/components/com_advform -name "*.php" 2>/dev/null); do
    check_php_syntax "$phpfile"
done
echo ""

echo "9. Checking Documentation..."
echo "-----------------------------------"
check_file "README.md"
check_file "INSTALLATION.md"
check_file "CHANGELOG.md"
check_file "CONTRIBUTING.md"
check_file "LICENSE"
check_file ".gitignore"
echo ""

echo "10. Component Statistics..."
echo "-----------------------------------"
echo "PHP Files: $(find administrator/components/com_advform -name "*.php" 2>/dev/null | wc -l)"
echo "XML Files: $(find administrator/components/com_advform -name "*.xml" 2>/dev/null | wc -l)"
echo "Language Strings: $(grep -c "^COM_ADVFORM" administrator/components/com_advform/language/en-GB/com_advform.ini 2>/dev/null || echo 0)"
echo "SQL Tables: $(grep -c "CREATE TABLE" administrator/components/com_advform/sql/install.mysql.utf8.sql 2>/dev/null || echo 0)"
echo ""

echo "=========================================="
echo "Validation Summary"
echo "=========================================="
if [ $ERRORS -eq 0 ]; then
    echo -e "${GREEN}✓ All checks passed!${NC}"
    echo "Component is ready for installation."
    exit 0
else
    echo -e "${RED}✗ Found $ERRORS error(s)${NC}"
    echo "Please fix the errors before installation."
    exit 1
fi
