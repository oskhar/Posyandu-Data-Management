# vue

This template should help get you started developing with Vue 3 in Vite.

## Recommended IDE Setup

[VSCode](https://code.visualstudio.com/) + [Volar](https://marketplace.visualstudio.com/items?itemName=johnsoncodehk.volar) (and disable Vetur).

## Type Support for `.vue` Imports in TS

Since TypeScript cannot handle type information for `.vue` imports, they are shimmed to be a generic Vue component type by default. In most cases this is fine if you don't really care about component prop types outside of templates.

However, if you wish to get actual prop types in `.vue` imports (for example to get props validation when using manual `h(...)` calls), you can run `Volar: Switch TS Plugin on/off` from VSCode command palette.

## Customize configuration

See [Vite Configuration Reference](https://vitejs.dev/config/).

## Project Setup

#### 1. Install list depedensi composer
```sh
composer install
```

#### 2. Install node module

> **Note**: Pastikan semuanya terinstall dengan baik
```sh
npm install
```

#### 3. Menggenerate key enkripsi milik laravel
```sh
php artisan key:generate
```

### Compile and Hot-Reload for **Development**

```sh
php artisan serve
```

```sh
npm run dev
```

### Type-Check, Compile and Minify for **Production**

#### Launch masa production

> **Note**: Hanya dijalankan jika app sudah sepenuhnya selesai
```sh
npm run build
```
