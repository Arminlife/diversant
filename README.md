# Welcome to WordPress boilerplate

## Get started

1. Install Node.js and Bun for your OS: https://bun.sh/docs/installation

2. Reload VS Code and install npm packages:
   `bun install`

3. Let's code!

- `bun run dev` - File watching + server
- `bun run q` - "dev" analog, but without opening a tab in the browser
- `bun run build` - Build (production mode)
- `bun run staging` - Build + dev widget (production mode)

## Template structure

```
│
├── .github                          # Configuration for bundling, NOT-used variables in production bundle.
│   ├── workflows                    # Configuration for GitHub Actions (deployment)
│   ├── copilot-instructions.md      # Default Copilot system prompt, containing codestyle directives and use cases
│   ├── prompts.md                   # Usable prompts for development
│
.helpers                             # All types of samples and plugins
│
.scripts                             # Development scripts for bundling, debugging, etc.
│
build                                # Production bundle
│
dist                                 # Dev bundle
│
src                                  # Sources
├── fonts                            # Fonts
├── images                           # Images
│   ├── sprite-icons                 # Sprite icons (SVG only)
├── js                               # Scripts
│   ├── components                   # JavaScript components for UI functionality & additional logic
│   ├── utils                        # Utility functions and constants
│   ├── vendors                      # Plugins and locally-used libraries
│   ├── app.js                       # Root file for component execution
├── pug                              # Pug & HTML files (templating)
│   ├── blocks                       # Blocks, sections
│   |   ├── components               # Universal components
├── scss                             # Styles
│   ├── blocks                       # Styles for pug sections
│   |   ├── components               # Styles for pug universal components
│   ├── utils                        # Utility styles and variables
│   ├── vendors                      # Styles for specific plugins & libs
│   ├── base.scss                    # Global styles for all pages
├── static                           # Static files that don't need to be processed. Just transfer to the bundle (like public in React).
├── wordpress                        # WordPress files, ideally must be equivalent to the files on the server. Themes, plugins, backup, templates
.env                                 # Configuration for bundling, NOT-used variables in production bundle.
```

## Code style:

Naming:

- Only English glossary allowed
- Component_block--modifier for CSS/SCSS classes. Example: .header, .header\_\_nav, .header\_\_nav--large_mod; .about_hero, .about_hero\_\_content_inner, .about_hero\_\_content_inner--color_mod;
- Kebab-case for all files, SCSS/PUG/JS/PHP. Example: foo-bar-baz.extname;
- Pascal Case - for JavaScript classes. Example: PascalCase;
- Camel Case - for regular JavaScript. Example: camelCase;
- Capitalized Snake Case - for PHP classes. Example: Capitalized_Snake_Case;
- Snake Case - for regular PHP and PUG variables. Example: snake_case;

Code writing:

- Limited nesting of SCSS selectors. See #copilot-instructions.md for references;
- Group styles into blocks. Follow this order: 1. Position, z-index; 2. Block model and size (flex, padding, etc.); 3. Typography; 4. Other styles;
- Try not to use !important unless necessary;
- Don't duplicate styles;

- Functional approach to JavaScript and prioritizing pure functions;
- Check the existence of variables/functions before using them or performing operations;
- Actively use optional chaining;
- Pure component functions, meaning all querySelectors are related to a certain DOM parent, not the document.
- To obtain elements via querySelector, primarily use data attributes. Example: document.querySelector('[data-header]'), document.querySelector('[data-animation-element]'). This is necessary to visually separate JS selectors.

- Remove non-functional code chunks (trash), comments;
- Remove debug code in production, debug console logs;
- Formatted, prettified code (Prettier);
- Tabs for code indentation, tab size – 2 spaces;

- Accessibility: ALT texts, aria-labels, correct type for ```<button>```, ```<input>``` tags. Readable labels for forms;
- Semantic structure. Use inline tags for text content for SEO purposes. For example: ```<span>```, ```<p>```, ```<h1>```, ```<h2>```, etc.;
- ```<ul>``` ```<li>``` for lists;

- Wrap images in a ```<div>``` and style it. Then it will be easier to replace ```<div>``` with ```<a>```, or add animation if necessary;
- Don't use lazy loading resources in hero sections;
- Set size for images using width/height/aspect-ratio CSS properties.

Best practices for development:

- Cross-browser;
- Pixel perfect (2–4px max difference);
- KISS for HTML markup;
- Minified code versions for production;
- Optimized formats;
- Valid, semantic, accessible HTML;
- Modern practices for code and avoiding outdated dependencies, APIs, and styles;
- Maintain color contrast;
- If the same code is executed more than twice, do not duplicate it but move it to a reusable function/component;
- Use proven plugins and libraries that are relevant in the community;
- Do not use external resources. For example: fonts or images. The developer must be able to work completely locally, without Internet access;
- Add hovers, change cursor for interactive UI elements;

# GitHub & Committing style

- Basically, two branches are created: main and staging.
  And a separate branch for each developer. Naming example: dev_george / dev_artem

- Conventional commits:
  https://www.conventionalcommits.org/en/v1.0.0/#summary
