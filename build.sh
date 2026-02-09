#!/bin/bash
# Build script for com_advform component

# Set variables
COMPONENT_NAME="com_advform"
VERSION="1.0.0"
BUILD_DIR="build"
PACKAGE_DIR="${BUILD_DIR}/package"
PACKAGE_NAME="${COMPONENT_NAME}_${VERSION}.zip"

# Clean previous build
echo "Cleaning previous build..."
rm -rf ${BUILD_DIR}
mkdir -p ${PACKAGE_DIR}

# Copy manifest file to root
echo "Copying manifest file..."
cp advform.xml ${PACKAGE_DIR}/

# Copy administrator files
echo "Copying administrator files..."
mkdir -p ${PACKAGE_DIR}/administrator/components/com_advform
cp -r administrator/components/com_advform/* ${PACKAGE_DIR}/administrator/components/com_advform/

# Copy site files  
echo "Copying site files..."
mkdir -p ${PACKAGE_DIR}/components/com_advform
cp -r components/com_advform/* ${PACKAGE_DIR}/components/com_advform/

# Create package
echo "Creating installation package..."
cd ${PACKAGE_DIR}
zip -r ../${PACKAGE_NAME} *
cd ../..

echo ""
echo "========================================="
echo "Package created: ${BUILD_DIR}/${PACKAGE_NAME}"
echo "========================================="
echo ""
echo "To install:"
echo "1. Log into your Joomla Administrator panel"
echo "2. Go to System → Install → Extensions"
echo "3. Upload ${BUILD_DIR}/${PACKAGE_NAME}"
echo "4. Click 'Upload & Install'"
echo ""
echo "Build complete!"
