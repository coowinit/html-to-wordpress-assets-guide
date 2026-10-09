# 第 08 章：三个阶段同一套资源架构

> v1.0.0 演示与验收说明。全部 HTML/PHP 源码已经整理为分层缩进，便于阅读与横向对比。

## 目标

对比单页、多页与 WordPress 主题之间如何从手写 `<link>`、`<script>` 升级到 enqueue，同时尽量保留 CSS/JS 源码。

## 阶段一：单页面

只有 `index.html`、`style.css`、`main.js`。使用 `defer` 确保初始化时 DOM 已被解析。

## 阶段二：多页面

- `common.css`、`common.js` 由四个页面共用。
- `pages/home.*` 只在首页使用。
- `pages/products.*` 只在产品页使用。
- `pages/contact.*` 只在联系页使用。
- About 不需要额外 JS，不创建空文件。

## 阶段三：WordPress

- CSS/JS 文件**与阶段二完全相同**，仅换加载方式。
- `functions.php` 加载 `inc/enqueue.php`，集中使用 `wp_enqueue_scripts`。
- `is_front_page()`、`is_page('products')`、`is_page('contact')` 限制资源范围。
- `wp_head()`、`wp_footer()` 保留，并包含 `wp_body_open()`。
- 通过 `filemtime()` 生成演示版本；正式项目应有稳定的发布版本策略。

## 验收步骤

| 场景 | 预期 |
| --- | --- |
| 首页 | 按钮写出“页面专属 JavaScript 已正常运行。” |
| 手机窄屏 | 菜单按钮可展开/收起导航 |
| 关于页 | 无专属 CSS/JS 请求 |
| 产品页 | “地板/墙板/全部”筛选正常 |
| 联系页 | 必填验证 + 本地提示，不发送信息 |
| WordPress 首页 | 只入队首页的专属资源 |
| WordPress 产品页 | 只入队产品页的专属资源 |
| WordPress 联系页 | 只入队联系页的专属资源 |
| WP 登录/退出 | 游客及管理员前台行为一致 |

## 注意与限制

- HTML 的导航在多页面阶段仍需重复维护；本项目不引入模板引擎，仅演示 CSS/JS 资源分离。
- WordPress 示例用精确 slug 做条件判断和演示模板绑定，仅供测试；真正多语言站点应根据明确模板、内容类型等条件组织。
- JS 的 `data-initialized` 是静态页面的简易保护，并非动态组件销毁系统。
- 生产站点应另行评估安全性、SEO、可访问性与业务需求。
