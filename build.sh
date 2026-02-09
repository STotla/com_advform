#!/bin/bash
# Build script for com_advform component

# Set variables
COMPONENT_NAME="com_advform"
VERSION="1.0.0"
BUILD_DIR="build"
PACKAGE_NAME="${COMPONENT_NAME}_${VERSION}.zip"

# Clean previous build
echo "Cleaning previous build..."
rm -rf ${BUILD_DIR}
mkdir -p ${BUILD_DIR}/${COMPONENT_NAME}

# Copy administrator files
echo "Copying administrator files..."
cp -r administrator/components/com_advform/* ${BUILD_DIR}/${COMPONENT_NAME}/

# Copy site files  
echo "Copying site files..."
mkdir -p ${BUILD_DIR}/${COMPONENT_NAME}/site
cp -r components/com_advform/* ${BUILD_DIR}/${COMPONENT_NAME}/site/

# Create package
echo "Creating installation package..."
cd ${BUILD_DIR}
zip -r ${PACKAGE_NAME} ${COMPONENT_NAME}/
cd ..

echo "Package created: ${BUILD_DIR}/${PACKAGE_NAME}"
echo "Build complete!"
