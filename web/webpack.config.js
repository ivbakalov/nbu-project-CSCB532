const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const HtmlWebpackPlugin = require("html-webpack-plugin");
const devMode = process.env.NODE_ENV !== "production";
module.exports = {
    name: "nbu project CSCB532",
    ...(devMode && {devtool: "source-map"}),
    mode: devMode ? "development" : "production",
    entry: {
        bundle: [
            path.resolve(__dirname, "node_modules/metro4/build", "metro.js"),
            path.resolve(__dirname, "assets/scripts", "index.js"),
            path.resolve(__dirname, 'assets/sass', 'style.scss'),
        ],
    },
    output: {
        path: path.resolve(__dirname, "dist"),
    },
    module: {
        rules: [
            {
                test: /\.html$/i,
                loader: "html-loader",
            },
            {
                test: /\.(js)$/,
                exclude: /node_modules/,
                use: ["babel-loader"],
            },
            {
                test: /\.s[ac]ss$/i,
                use: [MiniCssExtractPlugin.loader, 'css-loader', 'postcss-loader', 'sass-loader'],
            },
            {
                test: /\.(svg|json)$/,
                type: "asset/source",
            },
            {
                test: /\.(icon)$/,
                type: "asset/source",
            },
        ],
    },
    optimization: {
        minimizer: [new CssMinimizerPlugin(), "..."],
    },
    plugins: [new MiniCssExtractPlugin(), new HtmlWebpackPlugin({template: path.resolve(__dirname, "index.html")})],
    devServer: {
        historyApiFallback: true,
        static: path.resolve(__dirname, 'dist'),
        open: true,
        hot: true
    },
};
