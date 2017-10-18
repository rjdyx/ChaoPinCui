const path = require('path');
const env = require('./env.js');
const webpack = require('webpack');
const merge = require('webpack-merge');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');

const projectRoot = path.resolve(__dirname, './');

let config = {

    entry: {
        index: '@/index.js',
        vendor: [
            'axios',
            'jquery',
            'vue',
            'vue-router', 
            'vuex'
        ]
    },
    output: {
        path: projectRoot + '/public/build',
        publicPath: (process.env.NODE_ENV == 'development' ? env.app_url + '/build/' : '/build/'),
        filename: 'js/[name].js',
        chunkFilename: 'js/[id].[name].js'
    },
    module: {
        //加载器配置
        loaders: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                // vue-loader 配置
                options: {
                    loaders: {
                        // 用 babel-loader 加载所有没有 'lang' 属性的 <script>
                        // 将vue里面的css和sass抽离出来组成一个独立的css文件
                        css: ExtractTextPlugin.extract({
                            fallback: 'style-loader',
                            use: ['css-loader']
                        }),
                        scss: ExtractTextPlugin.extract({
                            fallback: 'vue-style-loader',
                            use: ['css-loader!sass-loader']
                        }),
                        sass: ExtractTextPlugin.extract({
                            fallback: 'vue-style-loader',
                            use: ['css-loader!sass-loader']
                        })
                    }
                }
            },
            {
                test: /\.css$/,
                loader: ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: ['css-loader']
                })
            },
            {
                test: /\.json$/,
                loader: 'json-loader'
            },
            // {
            //     test: /iview.src.*?js$/,
            //     loader: 'babel-loader'
            // },
            {
                test: /\.js$/,
                loader: 'babel-loader',
                // include: projectRoot,
                exclude: /node_modules/
            },
            {
                test: /\.scss$/,
                use: ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: ['css-loader', 'sass-loader']
                })
            },
            {
                test: /\.(eot|svg|ttf|woff|woff2)(\?\S*)?$/,
                loader: 'file-loader'
            },
            {
                test: /\.(png|jpe?g|gif|svg)(\?\S*)?$/,
                loader: 'file-loader',
                query: {
                  name: '[name].[ext]?[hash]'
                }
            }
        ]
    },
    // 配置应用层的模块（要被打包的模块）解析
    resolve: {
        // 这样就无需写后缀
        extensions: ['.js', '.vue'],
        // 路径别名
        alias: {
            'projectRoot': projectRoot,
            'vue$': 'vue/dist/vue',
            'sass': path.resolve(__dirname, './resources/assets/sass'),
            '@': path.resolve(__dirname, './resources/assets/js'),
            'lang': path.resolve(__dirname, './resources/lang'),
            'components': path.resolve(__dirname, './resources/assets/js/components'),
            'utils': path.resolve(__dirname, './resources/assets/js/utils'),
            'api': path.resolve(__dirname, './resources/assets/js/api')
        }
    },

    // 插件项
    plugins: [
        // 把css抽离成单独的文件
        new ExtractTextPlugin({filename: 'css/[name].css', allChunks: true}),
        // 将类库文件进行分开打包,便于缓存
        new webpack.optimize.CommonsChunkPlugin({
          name: 'vendor',
          filename: 'js/vendor-bundle.js'
        }),
        // 定义全局引用
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery',
            'window.$': 'jquery',

            axios: 'axios',
            'window.axios': 'axios',

            Vue: 'vue',
            'window.Vue': 'vue'
        })
    ],

    node: {
      fs: "empty",
      module: 'empty',
      child_process: 'empty'
    }
}

if(process.env.NODE_ENV == 'development') {
    config = merge(config, {
        plugins: [
            new webpack.DefinePlugin({
                'process.env.NODE.ENV': "development"
            }),
            // new webpack.HotModuleReplacementPlugin()
        ],
        devServer: {
            historyApiFallback: true,
            hot: true,
            inline: true,
            progress: true,
            proxy: {
                '/**': {
                    changeOrigin: true,
                    target: env.app_url,
                    secure: false,
                }
            }
        }
    })
}else {
    config = merge(config, {
        plugins: [
            new webpack.DefinePlugin({
                'process.env.NODE.ENV': "development"
            }),
            // minify JS
            new UglifyJSPlugin()
        ]
    })
}
module.exports = config