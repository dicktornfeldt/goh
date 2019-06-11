"use strict";

const webpack = require("webpack");
const autoprefixer = require("autoprefixer");
const AssetsPlugin = require("assets-webpack-plugin");
const BrowserSyncPlugin = require("browser-sync-webpack-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CleanWebpackPlugin = require("clean-webpack-plugin");
const TerserPlugin = require("terser-webpack-plugin");
const FriendlyErrorsPlugin = require("friendly-errors-webpack-plugin");
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const path = require("path");
const fs = require("fs");

// Make sure any symlinks in the project folder are resolved:
// https://github.com/facebookincubator/create-react-app/issues/637
const appDirectory = fs.realpathSync(process.cwd());

function resolveApp(relativePath) {
  return path.resolve(appDirectory, relativePath);
}

const paths = {
  appSrc: resolveApp("src"),
  appBuild: resolveApp("build"),
  appIndexJs: resolveApp("src/index.js"),
  appNodeModules: resolveApp("node_modules")
};

// the path(s) that should be cleaned upon build
const pathsToClean = ["build"];

// the clean options to use
const cleanOptions = {
  root: path.resolve(),
  verbose: true,
  dry: false
};

const DEV = process.env.NODE_ENV === "development";

module.exports = {
  bail: !DEV,
  mode: DEV ? "development" : "production",
  // We generate sourcemaps in production. This is slow but gives good results.
  // You can exclude the *.map files from the build during deployment.
  target: "web",
  devtool: DEV ? "cheap-eval-source-map" : "source-map",
  entry: [paths.appIndexJs],
  output: {
    path: paths.appBuild,
    filename: DEV ? "bundle.js" : "bundle.[hash:8].js"
  },
  module: {
    rules: [
      // Disable require.ensure as it's not a standard language feature.
      { parser: { requireEnsure: false } },
      // Transform ES6 with Babel
      {
        test: /\.js?$/,
        loader: "babel-loader",
        include: paths.appSrc
      },
      // Include local fonts and images
      {
        test: /\.(ttf|otf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
        include: paths.appSrc,
        loader: "file-loader"
      },
      {
        test: /.scss$/,
        use: [
          MiniCssExtractPlugin.loader,
          {
            loader: "css-loader"
          },
          {
            loader: "postcss-loader",
            options: {
              ident: "postcss", // https://webpack.js.org/guides/migrating/#complex-options
              plugins: () => [autoprefixer()]
            }
          },
          "sass-loader"
        ]
      }
    ]
  },
  optimization: {
    minimize: !DEV,
    minimizer: [
      new OptimizeCSSAssetsPlugin({
        cssProcessorOptions: {
          map: {
            inline: false,
            annotation: true
          }
        }
      }),
      new TerserPlugin({
        terserOptions: {
          compress: {
            warnings: false
          },
          output: {
            comments: false
          }
        },
        sourceMap: true
      })
    ]
  },
  plugins: [
    !DEV && new CleanWebpackPlugin(pathsToClean, cleanOptions),
    new MiniCssExtractPlugin({
      filename: DEV ? "bundle.css" : "bundle.[hash:8].css"
    }),
    new webpack.EnvironmentPlugin({
      NODE_ENV: "development", // use 'development' unless process.env.NODE_ENV is defined
      DEBUG: false
    }),
    new AssetsPlugin({
      path: paths.appBuild,
      filename: "assets.json"
    }),
    DEV &&
      new FriendlyErrorsPlugin({
        clearConsole: false
      }),
    DEV &&
      new BrowserSyncPlugin({
        notify: false,
        host: "localhost",
        port: 4000,
        logLevel: "silent",
        files: [
          // watching on changes
          {
            match: [
              appDirectory + "/**/*.twig",
              appDirectory + "/**/*.php",
              appDirectory + "/**/*.scss",
              appDirectory + "/**/*.js"
            ],
            fn: function(event, file) {
              if (event === "change") {
                // get the named instance
                const bs = require("browser-sync").get("bs-webpack-plugin");
                bs.reload();
              }
            }
          }
        ],
        proxy: "https://goh.test/"
      })
  ].filter(Boolean)
};
