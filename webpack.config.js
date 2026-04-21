const path = require("path");
const fs = require("fs");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

const pick = (dir, exts) =>
	fs
		.readdirSync(path.resolve(__dirname, dir))
		.filter((file) => exts.includes(path.extname(file)))
		.sort()
		.map((file) => `./${dir}/${file}`);




module.exports = {
	mode: "production",
	entry: {
		admin: [...pick("assets/admin/js", [".js"]), ...pick("assets/admin/scss", [".scss", ".css"])],
		public: [...pick("assets/public/js", [".js"]), ...pick("assets/public/scss", [".scss", ".css"])],
	},
	output: {
		path: path.resolve(__dirname, "build"),
		filename: "js/[name].js",
		clean: true,
	},
	module: {
		rules: [
			{ test: /\.css$/i, use: [MiniCssExtractPlugin.loader, "css-loader"] },
			{ test: /\.s[ac]ss$/i, use: [MiniCssExtractPlugin.loader, "css-loader", "sass-loader"] },
		],
	},
	plugins: [new MiniCssExtractPlugin({ filename: "css/[name].css" })],
};
