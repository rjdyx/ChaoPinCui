const ExtractTextPlugin = require('extract-text-webpack-plugin')

module.exports = {
  loaders: {
    // 用 babel-loader 加载所有没有 "lang" 属性的 <script>
    js: 'babel-loader',
    // 将vue里面的css、sass和less抽离出来组成一个独立的css文件
    css: ExtractTextPlugin.extract({fallback: 'vue-style-loader', use: 'css-loader'}),
    sass: ExtractTextPlugin.extract({fallback: 'vue-style-loader', use: 'css-loader!sass-loader'})
  },
  postcss: [
    require('autoprefixer')({
      browsers: ['iOS >= 7', 'Android >= 4.1']
    })
  ]
}
