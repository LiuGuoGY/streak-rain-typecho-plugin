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
<script src="http://github.zhusaidong.cn/streak-rain/dist/streak-rain-min.js"></script>
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

