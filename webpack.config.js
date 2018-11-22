var path = require('path');

module.exports = env => {
    var config = {
        entry: {
            'js': [
                "./resources/js/app.jsx",
                "./resources/sass/app.scss"
            ],
        },
        resolve: {
            extensions: ['.js', '.jsx']
        },
        module: {
            rules: [
                {
                    test: /\.jsx$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-react']
                        }
                    }
                },
                {
                    test: /\.scss$/,
                    use: [
                        { 
                            loader: "style-loader"
                        }, 
                        {
                            loader: "css-loader"
                        }, 
                        {
                            loader: "sass-loader",
                        }
                    ]
                }
            ]
        },
    };

    if (env && env.production) {
        config.mode = 'production';
        config.output = {
            filename: '[name].js',
            path: __dirname + '/public/js/dist'
        };
    } else {
        config.mode = "development";
    
        // Enable sourcemaps for debugging webpack's output.
        config.devtool = "source-map";
        config.output = {
            filename: '[name].js',
            path: __dirname + '/public/js/dev'
        };
    }
        
    return config;
};
