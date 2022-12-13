<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
* 线条雨背景
* 
* @package StreakRain
* @author 上官元恒
* @link http://blog.zhusaidong.cn
* @version 1.1.0
*/
class StreakRain_Plugin  implements Typecho_Plugin_Interface
{
	//这个是插件的激活接口，主要填写一些插件的初始化程序
	public static function activate()
	{
		Typecho_Plugin::factory('Widget_Archive')->footer_StreakRain = array('StreakRain_Plugin', 'ShowStreakRain');
		return '插件安装成功，请进入设置';
	}
	//这个是插件的禁用接口，主要就是插件在禁用时对一些资源的释放
	public static function deactivate()
	{
		return '插件卸载成功';
	}
	//插件的配置面板，用于制作插件的标准配置菜单
	public static function config(Typecho_Widget_Helper_Form $form)
	{
        	$element = new Typecho_Widget_Helper_Form_Element_Text('StreakRain_speed', null, '60', _t('雨滴下落速度'), '雨滴下落速度');
		$form->addInput($element);
        	$element = new Typecho_Widget_Helper_Form_Element_Text('StreakRain_length', null, '10', _t('雨滴长度'), '雨滴长度');
		$form->addInput($element);
        	$element = new Typecho_Widget_Helper_Form_Element_Text('StreakRain_number', null, '60', _t('雨滴数量'), '雨滴数量');
		$form->addInput($element);
        	$element = new Typecho_Widget_Helper_Form_Element_Text('StreakRain_fgColor', null, '#ee0000', _t('前景色'), '前景色');
		$form->addInput($element);
        	$element = new Typecho_Widget_Helper_Form_Element_Text('StreakRain_bgColor', null, '#ffffff', _t('背景色'), '背景色');
		$form->addInput($element);

	}
	//插件的个性化配置面板
	public static function personalConfig(Typecho_Widget_Helper_Form $form)
	{
	}
	public static function ShowStreakRain($archive)
	{
		$options = Helper::options();
		$speed = $options->plugin('StreakRain')->StreakRain_speed;
		$length = $options->plugin('StreakRain')->StreakRain_length;
		$number = $options->plugin('StreakRain')->StreakRain_number;
		$fgColor = $options->plugin('StreakRain')->StreakRain_fgColor;
		$bgColor = $options->plugin('StreakRain')->StreakRain_bgColor;
		//输出js
		echo 
<<<eof
<style>
canvas
{
	position:fixed;
	z-index:-1;
	left:0px;
	top:0px;
}
</style>
<script>
function point(a, b) {
    this._constructor = function(a, b) {
        this.x = a, this.y = b
    }, this._constructor(a, b)
}
function rainObject(a, b, c) {
    this._constructor = function(a, b, c) {
        this.x = a, this.y = b;
        var d = 150 * c;
        this.rain = {
            start: new point(this.x - d, 0 - this.y),
            end: new point(this.x + 5 * c - d, 0)
        }, 0 != d && (this.rain.end.x = this.rain.start.x + Math.floor((this.rain.start.x - this.rain.end.x) / 2), this.rain.end.y = this.rain.start.y + Math.floor((this.rain.start.y - this.rain.end.y) / 2))
    }, this._constructor(a, b, c)
}
function StreakRain(a) {
    this._constructor = function(a) {
        this.rainDownSpeed = (a.speed || 60) / 60, this.rainLength = a.length || 10, this.rainNumber = (a.number || 60) / 60, this.fgColor = a.fgColor || "#ffffff", this.bgColor = a.bgColor || "#000000", this.windPower = 0, this.cOpacity = .5, this.rains = new Array, this.init(), this.randomRain(), this.windowResize(), 0 != this.windPower && this.mousePosition()
    }, this.init = function() {
        this.canvas = document.createElement("canvas"), this.canvas.id = (new Date).getTime(), this.canvas.textContent = "you brower not support canvas", this.canvas.width = window.innerWidth, this.canvas.height = window.innerHeight, this.canvas.style["background-color"] = this.bgColor, document.body.appendChild(this.canvas), document.body.style.margin = 0, document.body.style.padding = 0, this.ctx = this.canvas.getContext("2d"), this.ctx.globalAlpha = this.cOpacity, this.ctx.fillStyle = this.fgColor, this.ctx.strokeStyle = this.fgColor
    }, this.randomRain = function() {
        for (var a = this.windPower / Math.abs(this.windPower), b = Math.floor(this.canvas.width * (0 != this.windPower ? 2 : 1) / this.rainNumber), c = 0; c < this.rainNumber; c++) {
            var d = this.getRandom(3 * this.rainLength, 8 * this.rainLength),
                e = b * c,
                f = b * (c + 1);
            a < 0 && (e -= this.canvas.width, f -= this.canvas.width);
            var g = this.getRandom(e, f);
            this.rains.push(new rainObject(g, d, this.windPower))
        }
    }, this.run = function() {
        window.requestAnimationFrame || (window.requestAnimationFrame = window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.msRquestAniamtionFrame || window.oRequestAnimationFrame || function(a) {
            return setTimeout(a, Math.floor(1e3 / 60))
        }), window.requestAnimationFrame(this.run.bind(this)), this.clearScreen();
        for (var a in this.rains) this.line(this.rains[a].rain.start, this.rains[a].rain.end);
        var b = [];
        for (var a in this.rains) {
            var c = this.getRandom(1 * this.rainDownSpeed, 10 * this.rainDownSpeed);
            for (var d in this.rains[a].rain) this.rains[a].rain[d].x += this.windPower, this.rains[a].rain[d].y += c;
            this.rains[a].rain.start.y > this.canvas.height && b.push(a)
        }
        this.deleteRain(b), b = [], this.randomRain(this.rainNumber)
    }, this.deleteRain = function(a) {
        var b = new Array;
        for (var c in this.rains) a.includes(c) || b.push(this.rains[c]);
        this.rains = b
    }, this.windowResize = function() {
        var a = this;
        window.onresize = function() {
            a.canvas.width = window.innerWidth, a.canvas.height = window.innerHeight
        }
    }, this.mousePosition = function() {
        var a = this.windPower,
            b = this;
        this.canvas.addEventListener("mousemove", function(c) {
            var d = Math.floor(b.canvas.width / 2),
                e = c.clientX,
                f = Math.floor(d / 2 / 5),
                g = Math.floor((e - d) / f);
            b.windPower = a * g
        }, !1)
    }, this.getRandom = function(a, b) {
        return Math.floor(Math.random() * (b - a + 1) + a)
    }, this.line = function(a, b) {
        this.ctx.beginPath(), this.ctx.moveTo(a.x, a.y), this.ctx.lineTo(b.x, b.y), this.ctx.strokeStyle = this.fgColor, this.ctx.stroke(), this.ctx.closePath()
    }, this.clearScreen = function() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height), this.ctx.globalAlpha = this.cOpacity
    }, this._constructor(a)
}
</script>
<script>
	new StreakRain({
		speed	:"$speed",
		length	:"$length",
		number	:"$number",
		fgColor	:"$fgColor",
		bgColor	:"$bgColor",
	}).run();
</script>
eof;
	}
}

