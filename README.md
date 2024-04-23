# Kirby Role Blueprints

Simplified & automatic loading of different blueprints based on user roles in Kirby CMS.

Simply attach the role name as suffix to the blueprint file name and the plugin will load the corresponding blueprint.

### Usage

```
site
└── blueprints
    └── site.admin.yml -> Like site.yml, for admin users only
    └── site.default.yml -> Any other user
		└── pages
				├── blog-post.admin.yml -> Like pages/blog-post.yml, for admin users only
				├── blog-post.editor.yml -> Editor users only
				└── blog-post.default.yml -> Any other user
```

### Example

Since Kirby loads the blueprints normally as well, you can use a top-level `extends` in your blueprint to change single items.

```yaml
# site.default.yml
title: overview

tabs:
  main:
  # [...]
  seo: seo/site
```

```yaml
# site.admin.yml
extends: site.default

tabs:
  admin: tabs/admin-tools
```

In this case, the admin tab will be appended after the seo tab.
