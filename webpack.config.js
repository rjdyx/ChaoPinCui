const path = require('path')
const env = require('./env.js')
const webpack = require('webpack')
const merge = require('webpack-merge')
const vueLoaderConfig = require('./build/vue-loader.conf')
const ExtractTextPlugin = require('extract-text-webpack-plugin')

const projectRoot = path.resolve(__dirname, './')
function resolve (dir) {
    return path.join(__dirname, '.', dir)
}
const isProd = process.env.NODE_ENV === 'production'
process.traceDeprecation = true

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
        publicPath: (process.env.NODE_ENV == 'development' ? 'http://localhost:8080/build/' : '/build/'),
        filename: 'js/[name].js',
        chunkFilename: 'js/[id].[name].js'
    },
    module: {
        rules: [
            {
                test: /\.(js|vue)$/,
                loader: 'eslint-loader',
                enforce: 'pre',
                include: [resolve('resources'), resolve('tests')],
                options: {
                    formatter: require('eslint-friendly-formatter')
                }
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                options: vueLoaderConfig
            },
            {
                test: /\.css$/,
                use: isProd
                    ? ExtractTextPlugin.extract({
                        use: 'css-loader',
                        fallback: 'style-loader'
                    })
                    : ['style-loader', 'css-loader']
            },
            {
                test: /\.scss$/,
                use: isProd
                    ? ExtractTextPlugin.extract({
                        use: 'css-loader!sass-loader',
                        fallback: 'style-loader'
                    })
                    : ['style-loader', 'css-loader', 'sass-loader']
            },
            {
                test: /\.js$/,
                loader: 'babel-loader',
                include: [resolve('resources'), resolve('tests')]
            },
            {
                test: /\.(png|jpe?g|gif|svg)(\?.*)?$/,
                loader: 'url-loader',
                options: {
                    limit: 10000,
                    name: path.posix.join('public', 'img/[name].[hash:7].[ext]')
                }
            },
            {
                test: /\.(woff2?|eot|ttf|otf)(\?.*)?$/,
                loader: 'url-loader',
                options: {
                    limit: 10000,
                    name: path.posix.join('public', 'fonts/[name].[hash:7].[ext]')
                }
            }
        ]
    },
    // 配置应用层的模块（要被打包的模块）解析
    resolve: {
        // 这样就无需写后缀
        extensions: ['.js', '.vue', '.json'],
        // 路径别名
        alias: {
            'vue': 'vue/dist/vue.js',
            '@': path.join(__dirname, './resources/assets/js'),
            'vue': 'vue/dist/vue.js',
            'projectRoot': projectRoot,
            'sass': path.resolve(__dirname, './resources/assets/sass'),
            'components': path.resolve(__dirname, './resources/assets/js/components'),
            'utils': path.resolve(__dirname, './resources/assets/js/utils'),
            'api': path.resolve(__dirname, './resources/assets/js/api')
        }
    },
    // 插件项
    plugins: [
        // 把css抽离成单独的文件
        new ExtractTextPlugin({ filename: 'css/[name].css',  allChunks: true }),
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
      fs: "empty"
    }
}

if(process.env.NODE_ENV == 'development') {
    config = merge(config, {
        plugins: [
            // new webpack.HotModuleReplacementPlugin(),
            new webpack.DefinePlugin({
                'process.env.NODE.ENV': "development"
            })
        ],
        devServer: {
            contentBase: "build/",
            historyApiFallback: true,
            hot: true,
            inline: true,
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
                'process.env.NODE.ENV': "prodution"
            }),
            // minify JS
            new webpack.optimize.UglifyJsPlugin({
              compress: {
                warnings: false
              }
            })
        ]
    })
}

module.exports = config