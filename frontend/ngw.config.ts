import * as webpack from 'webpack';
import { Path } from '@angular-devkit/core';
import { NormalizedBrowserBuilderSchema } from '@angular-devkit/build-angular';
const ManifestPlugin = require('webpack-manifest-plugin');

export type WebpackOptions<T = NormalizedBrowserBuilderSchema> = {
    root: Path,
    projectRoot: Path,
    options: T;
};

const command = process.argv[2].toLowerCase();

export default function (config: webpack.Configuration, options: WebpackOptions) {
    config.plugins.push(
        new ManifestPlugin({
            publicPath: 'spa/'
        })
    );
    return config;
}
