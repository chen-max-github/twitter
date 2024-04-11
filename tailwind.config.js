/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./views/*.html"],
  theme: {
    colors: {
      slate: {
        900: "#64748b",
        700: "#334155",
      },

      teal: "#042f2e",
      blue: "#3b82f6",
      black: "#000000",
      white: "#FFF",
      gray: "#6b7280",
      zinc: "#71717a",
    },
  },
  plugins: [require("@tailwindcss/forms"), require("@tailwindcss/typography")],
};
