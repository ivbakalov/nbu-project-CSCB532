module.exports = {
  presets: [
    [
      "@babel/preset-env",
      {
        debug: process.env.NODE_ENV !== "production",
        corejs: "3",
        useBuiltIns: "usage",
      },
    ],
  ],

  plugins: [],
};
