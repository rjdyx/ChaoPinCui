# ChaoPinCui (潮品萃)
1. 描述
	为广东潮州市搭建一个展示特色文化的搜索平台，如小吃、景点、茶叶、文化等。
	当前项目为后端接口，只做数据返回，不加载页面。

2. 版本及环境
	Lavavel 5.4 + php6.6及以上

3. 结构
	（1）Route(路由) 为Api模式 (当前web,后面移动)
	（2）Model路径为 app\models\..
	（3）前端控制器 api\home\.. , 后端控制器api\admin\..

4. 工具类 (自定义门面)
	IQuery位置：app\Utils\IQuery.php
	使用方法：use IQuery

