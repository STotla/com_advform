# Contributing to com_advform

Thank you for your interest in contributing to the Advanced Form component for Joomla 5! This document provides guidelines and instructions for contributing.

## Table of Contents

1. [Code of Conduct](#code-of-conduct)
2. [Getting Started](#getting-started)
3. [Development Setup](#development-setup)
4. [Coding Standards](#coding-standards)
5. [Making Changes](#making-changes)
6. [Submitting Changes](#submitting-changes)
7. [Reporting Bugs](#reporting-bugs)
8. [Feature Requests](#feature-requests)

## Code of Conduct

By participating in this project, you agree to maintain a respectful and inclusive environment for everyone.

### Our Standards

- Be respectful and professional
- Accept constructive criticism gracefully
- Focus on what's best for the community
- Show empathy towards others

## Getting Started

### Prerequisites

- Git installed on your machine
- Joomla 5.0+ development environment
- PHP 8.1 or higher
- MySQL 5.7+ or MariaDB 10.3+
- Basic understanding of Joomla MVC architecture

### Fork and Clone

1. Fork the repository on GitHub
2. Clone your fork locally:
   ```bash
   git clone https://github.com/YOUR-USERNAME/com_advform.git
   cd com_advform
   ```

3. Add the upstream repository:
   ```bash
   git remote add upstream https://github.com/STotla/com_advform.git
   ```

## Development Setup

### Option 1: Direct Installation

1. Copy files to your Joomla installation:
   ```bash
   # Administrator files
   ln -s $(pwd)/administrator/components/com_advform /path/to/joomla/administrator/components/com_advform
   
   # Site files
   ln -s $(pwd)/components/com_advform /path/to/joomla/components/com_advform
   ```

2. Install database tables:
   ```bash
   mysql -u user -p database < administrator/components/com_advform/sql/install.mysql.utf8.sql
   ```

### Option 2: Build and Install

1. Build the package:
   ```bash
   ./build.sh
   ```

2. Install via Joomla's extension installer

### Enable Development Mode

In Joomla's `configuration.php`, set:
```php
public $debug = '1';
public $error_reporting = 'maximum';
```

## Coding Standards

We follow the [Joomla Coding Standards](https://developer.joomla.org/coding-standards.html).

### PHP Standards

- Use PHP 8.1+ features where appropriate
- Follow PSR-12 coding style
- Use proper type hints and return types
- Document all public methods with PHPDoc
- Use meaningful variable and function names

### Example:

```php
<?php
/**
 * Calculate the field ordering.
 *
 * @param   int     $fieldId    The field ID
 * @param   string  $direction  The ordering direction
 *
 * @return  int  The new ordering value
 *
 * @since   1.1.0
 */
public function calculateOrdering(int $fieldId, string $direction = 'up'): int
{
    // Implementation
}
```

### Namespace Convention

Use the established namespace:
```php
namespace SamWebTechnologies\Component\Advform\Administrator\...;
```

### Database Queries

Always use Joomla's database query builder:

```php
$db = $this->getDatabase();
$query = $db->getQuery(true);

$query->select($db->quoteName(['id', 'title']))
    ->from($db->quoteName('#__advform_fields'))
    ->where($db->quoteName('state') . ' = 1');

$db->setQuery($query);
$results = $db->loadObjectList();
```

### Security

- Never trust user input
- Always sanitize and validate data
- Use Joomla's form validation
- Escape output appropriately
- Check permissions before operations

## Making Changes

### Branch Strategy

1. Create a feature branch from `main`:
   ```bash
   git checkout -b feature/your-feature-name
   ```

   Or for bug fixes:
   ```bash
   git checkout -b bugfix/issue-description
   ```

### Commit Messages

Follow the conventional commits format:

```
type(scope): subject

body

footer
```

**Types:**
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes (formatting)
- `refactor`: Code refactoring
- `test`: Adding tests
- `chore`: Maintenance tasks

**Examples:**
```
feat(fields): add field duplication functionality

Implement ability to duplicate existing fields with all settings.
Includes new controller method and UI button.

Closes #123
```

```
fix(model): correct field name validation

Fix issue where field names with numbers were rejected incorrectly.

Fixes #456
```

### Testing Your Changes

Before submitting:

1. **Test manually:**
   - Create, edit, delete fields
   - Test all field types
   - Verify permissions work correctly
   - Check with different user roles

2. **Check for errors:**
   - Enable Joomla debug mode
   - Check browser console for JavaScript errors
   - Review PHP error logs

3. **Test database operations:**
   - Verify SQL queries work correctly
   - Check data integrity after operations

4. **Cross-browser testing** (if UI changes):
   - Chrome/Edge
   - Firefox
   - Safari

## Submitting Changes

### Pull Request Process

1. **Update your fork:**
   ```bash
   git fetch upstream
   git rebase upstream/main
   ```

2. **Push to your fork:**
   ```bash
   git push origin feature/your-feature-name
   ```

3. **Create Pull Request:**
   - Go to the original repository on GitHub
   - Click "New Pull Request"
   - Select your fork and branch
   - Fill in the PR template

### PR Guidelines

Your PR should include:

- **Clear description** of what changes were made and why
- **Reference to issue** if applicable (Closes #123)
- **Screenshots** if UI changes
- **Testing steps** for reviewers
- **Backward compatibility** notes if relevant

### PR Template

```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Testing
Describe how to test the changes

## Screenshots (if applicable)
Add screenshots here

## Checklist
- [ ] Code follows project style guidelines
- [ ] Self-review completed
- [ ] Changes are tested
- [ ] Documentation updated
- [ ] No new warnings generated
```

## Reporting Bugs

### Before Reporting

1. Search existing issues to avoid duplicates
2. Test with latest version
3. Test with Joomla's default template
4. Disable other extensions to rule out conflicts

### Bug Report Template

```markdown
**Describe the bug**
A clear description of what the bug is.

**To Reproduce**
Steps to reproduce:
1. Go to '...'
2. Click on '...'
3. See error

**Expected behavior**
What you expected to happen.

**Screenshots**
If applicable, add screenshots.

**Environment:**
- Joomla Version: [e.g., 5.0.2]
- PHP Version: [e.g., 8.1.15]
- MySQL Version: [e.g., 8.0.31]
- Component Version: [e.g., 1.0.0]
- Browser: [e.g., Chrome 120]

**Additional context**
Any other relevant information.
```

## Feature Requests

We welcome feature requests! Please:

1. Search existing requests first
2. Provide clear use case
3. Explain expected behavior
4. Consider implementation complexity
5. Be open to discussion

### Feature Request Template

```markdown
**Is your feature related to a problem?**
Description of the problem.

**Describe the solution you'd like**
Clear description of what you want to happen.

**Describe alternatives considered**
Other solutions you've considered.

**Additional context**
Any other relevant information.
```

## Development Roadmap

See [CHANGELOG.md](CHANGELOG.md) for planned features.

Current priorities:
1. Phase 2: Frontend integration
2. User profile field display
3. Form rendering functionality
4. Field value storage

## Questions?

If you have questions about contributing:

1. Check existing documentation
2. Review closed issues
3. Open a discussion on GitHub
4. Contact: admin@samwebtechnologies.com

## License

By contributing, you agree that your contributions will be licensed under the GNU General Public License v2.0 or later.

## Recognition

Contributors will be acknowledged in:
- CHANGELOG.md
- Release notes
- Project documentation

Thank you for contributing! 🎉
