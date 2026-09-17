# AGENTS.md

WordPress plugin that adds manual WooCommerce relay-point shipping methods and shows them as a pick list at checkout.

## Layout

- Plugin code lives in `src/`. WordPress.org and the Docker mount use that folder.
- Entry file is `src/woo_relay_shipping.php`. Shipping class is `src/modules/class_relay_shipping.php`.
- `src/readme.txt` is the WordPress.org readme. Keep it in sync with the plugin header version.
- `package.json` exists only for semantic-release. It is not an app manifest.
- `docker-compose.yml` mounts `./src` at `/var/www/html/wp-content/plugins/woocommerce-relay-shipping`.

## Commands

```bash
docker compose up
```

WordPress is at `http://localhost:8000`. WooCommerce is not preinstalled. Activate WooCommerce. Then activate the plugin.

## Invariants

Edit PHP under `src/`.
