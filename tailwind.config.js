/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
    require('daisyui'),
  ],
  daisyui: {
    themes: [
      {
        college: {
          "primary": "#3b82f6",
          "secondary": "#1e40af", 
          "accent": "#06b6d4",
          "neutral": "#1f2937",
          "base-100": "#ffffff",
          "info": "#0ea5e9",
          "success": "#10b981",
          "warning": "#f59e0b",
          "error": "#ef4444",
        },
      },
      "light",
      "dark",
      "cupcake",
      "corporate",
    ],
    darkTheme: "dark",
    base: true,
    styled: true,
    utils: true,
  },
}
