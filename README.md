# Busty Cache Controller

Busty is a small, purpose built WordPress plugin that provides targeted cache
busting for routes and endpoints that should never be cached. It was built to
support debugging, development, and dynamic behavior in environments where
aggressive page caching can interfere with expected functionality.

## What It Does

Busty gives you a clean and predictable way to force fresh responses on selected
endpoints. It applies cache bypass logic only where it is needed, which prevents
stale data, improves reliability, and gives you a clearer view into how the
cache layer is behaving. The plugin also sets proper cache headers so you can
confirm whether a response was meant to be cached, bypassed, or explicitly
busted.

The plugin includes:

• Route based cache busting  
• Custom user defined bust routes  
• Handling for ACF validation requests  
• Cache busting for admin edit screens  
• Cache busting for REST API responses  
• URL based rules for more control  
• Debug headers added to responses for visibility  
• Proper cache headers applied where appropriate  
• An admin panel with:  
  • Overview  
  • Settings  
  • Cache Rules  
  • Routes  
  • Logs  
  • Dictionary for quick reference

## Why It Exists

Most cache busting plugins try to solve every caching problem by adding layers
of features, complex filters, and heavy logic that is not always needed. They
tend to change too much, add bloat, and rarely give clear visibility into what
the cache is actually doing.

Busty takes the opposite approach. It stays small, direct, and fully transparent.
You define the routes. You define the rules. Busty handles the rest and shows
you exactly why a request was bypassed or busted through clear debug headers,
logs, and straightforward behavior.

This makes debugging faster, reduces confusion, and helps you understand how the
cache is performing across different environments.

## How It Works

Busty hooks into early WordPress request handling and inspects the incoming path.
If the request matches a route or condition that should not be cached, the
plugin:

1. Applies cache bust logic  
2. Sets the correct no cache headers  
3. Adds lightweight debug headers for visibility  
4. Records the behavior if logging is enabled  

If no rules match, the request continues through WordPress normally without any
interference.

## Logic Flow

The logic behind each request is intentionally simple:

1. Check for protected dynamic routes  
2. Check custom user defined routes  
3. Check known endpoints like REST, admin edit, or ACF validation  
4. Trigger cache busting only when a match occurs  
5. Add headers and context for debugging

This keeps performance high while maintaining clarity in how decisions are made.

## Architecture

The plugin is written with simple, readable PHP. Cache rules and conditions are
broken into dedicated components so responsibilities stay clean. Admin pages use
a consistent structure that makes it easy to add and extend features without
introducing noise or unnecessary complexity.

## Usage

This plugin is not intended for general public use. It was created for code
review and architectural demonstration.

## License
This project is proprietary and all rights are reserved.  
See the LICENSE file for details.
