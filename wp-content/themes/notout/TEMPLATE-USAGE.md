# Custom Page Template - Usage Guide

## Template File
**Location:** `wp-content/themes/notout/template-custom-page.php`
**Template Name:** Custom Full Width Template

## How to Use This Template

### Step 1: Create a New Page
1. Go to WordPress Admin Dashboard
2. Navigate to **Pages → Add New**
3. Enter your page title and content

### Step 2: Assign the Template
1. In the page editor, look for **Page Attributes** box (right sidebar)
2. Find the **Template** dropdown
3. Select **"Custom Full Width Template"**
4. Click **Publish** or **Update**

### Step 3: View Your Page
- Visit your new page to see the custom template in action
- The template will automatically use your page title and content

## Template Features

### 1. Hero Section
- Large banner at the top with gradient background
- Displays page title prominently
- Shows page excerpt (if available)
- Purple gradient background (customizable)

### 2. Main Content Area
- Clean, readable typography
- Your page content (from WordPress editor)
- Supports all WordPress content blocks
- Pagination support for multi-page content

### 3. Features Section
- Grid layout with 4 feature boxes
- Icons and descriptions
- Responsive design (stacks on mobile)
- Hover effects for interactivity

**Default Features:**
- 🎯 নিখুঁত নির্ভুলতা (Perfect Accuracy)
- ⚡ দ্রুত গতি (Fast Speed)
- 🛡️ সম্পূর্ণ নিরাপদ (Completely Safe)
- 📱 মোবাইল বান্ধব (Mobile Friendly)

### 4. Call-to-Action (CTA) Section
- Eye-catching gradient background
- Large heading and description
- Action button
- Designed to drive conversions

## Customization

### Change Colors
Edit the template file and modify these lines:

**Hero Section Background:**
```css
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
```

**CTA Section Background:**
```css
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
```

### Modify Features
Edit the feature boxes in the template:

```php
<div class="feature-icon" style="font-size: 3em; margin-bottom: 15px;">🎯</div>
<h3 style="margin-bottom: 10px;">নিখুঁত নির্ভুলতা</h3>
<p>সর্বোচ্চ মানের সেবা প্রদান</p>
```

### Change CTA Button Link
Find this line and change the `href` value:
```html
<a href="#" style="...">যোগ দিন</a>
```

Change `#` to your desired URL (e.g., `/register`, `/contact`)

## Responsive Design
The template is fully responsive:
- **Desktop:** Full width layout with grid features
- **Tablet:** Adjusted font sizes and spacing
- **Mobile:** Single column layout, stacked features

## Integration with Google Translate
The template automatically inherits the Google Translate functionality from your header.
- Language switcher works on all pages using this template
- Translations apply to all content sections

## Tips

1. **Use Page Excerpt:** Add an excerpt to your page for a custom hero description
2. **Rich Content:** Use WordPress editor for formatted content in main section
3. **Images:** Add images in the WordPress editor for better visual appeal
4. **Multiple Pages:** You can use this template for multiple pages

## Example Usage

**Landing Page:**
- Title: "নটআউট - আপনার বিশ্বস্ত পার্টনার"
- Template: Custom Full Width Template
- Content: Add your marketing copy

**About Page:**
- Title: "আমাদের সম্পর্কে"
- Template: Custom Full Width Template
- Content: Company history and values

**Services Page:**
- Title: "আমাদের সেবা"
- Template: Custom Full Width Template
- Content: Detailed service descriptions

## Technical Details

- **Compatible with:** WordPress 5.0+
- **Requires:** notout theme
- **File Type:** PHP template
- **Comments:** Supports WordPress comments (if enabled)
- **SEO:** Fully compatible with SEO plugins

## Support
For customization help, refer to WordPress template documentation or contact your developer.
