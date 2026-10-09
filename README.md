# 从 HTML 到 WordPress：CSS / JavaScript 资源组织与加载规范

> **v1.0.0 · 中文教学指南与三阶段可运行示例**  
> 面向从静态 HTML 开始开发企业网站、逐渐增加页面，最终将网站迁移为 WordPress 经典主题的开发者。

## 1. 这个仓库解决什么问题？

写一个 HTML 页面时，`<style>` 和 `<script>` 往往很方便；但当页面扩展到十几个、几十个时，重复样式、脚本加载顺序、第三方库版本、缓存与维护成本就会逐渐累积。本仓库不以改造旧主题为目标，而是从**新建项目**开始建立一套可持续的 CSS / JS 规范。

**核心原则：** 单页面保持简单；多页面按职责复用；WordPress 使用 enqueue 管理资源。先保证正确性，再测量和优化性能，避免过度设计。

## 2. 三个阶段对照

| 阶段 | 示例位置 | 核心目标 | CSS / JS 加载方式 |
| --- | --- | --- | --- |
| 01 · 单页面 | [`examples/01-single-html/`](examples/01-single-html/) | HTML、CSS、JS 分离 | `style.css` + `main.js`，原生 `defer` |
| 02 · 多页面 | [`examples/02-multiple-html/`](examples/02-multiple-html/) | 公共资源与页面资源拆分 | `common.*` + 按需 `pages/*` |
| 03 · WordPress | [`examples/03-wordpress-theme/wem-assets-demo/`](examples/03-wordpress-theme/wem-assets-demo/) | 资源文件保持复用，交由 WordPress 管理 | `wp_enqueue_style()` / `wp_enqueue_script()` |

**对照观察：** 阶段 02 的 CSS / JS 文件在阶段 03 中原样复用。变化集中在 HTML/PHP 模板及 `inc/enqueue.php`，有利于理解“业务代码”与“加载机制”的区别。

## 3. 仓库目录

```text
html-to-wordpress-assets-guide/
├── README.md
├── docs/
│   ├── 00-guide-outline.md
│   └── 08-example-project.md
└── examples/
    ├── 01-single-html/
    │   ├── index.html
    │   └── assets/
    │       ├── css/style.css
    │       └── js/main.js
    ├── 02-multiple-html/
    │   ├── index.html
    │   ├── about.html
    │   ├── products.html
    │   ├── contact.html
    │   └── assets/
    │       ├── css/common.css
    │       ├── css/pages/{home,products,contact}.css
    │       ├── js/common.js
    │       └── js/pages/{home,products,contact}.js
    └── 03-wordpress-theme/
        └── wem-assets-demo/
            ├── style.css
            ├── functions.php
            ├── header.php
            ├── footer.php
            ├── front-page.php
            ├── page.php
            ├── page-products.php
            ├── page-contact.php
            ├── index.php
            ├── inc/enqueue.php
            └── assets/（复用阶段 02 的 CSS / JS）
```

## 4. 快速开始

### 阶段 01：运行单页面 HTML

在仓库根目录打开 Windows PowerShell：

```powershell
cd examples/01-single-html
py -m http.server 8000
```

浏览器打开 `http://localhost:8000/`。按 `Ctrl+C` 停止服务器。

### 阶段 02：运行多页面 HTML

返回仓库根目录，然后执行：

```powershell
cd examples/02-multiple-html
py -m http.server 8000
```

测试 `index.html`、`about.html`、`products.html`、`contact.html`。在 Chrome DevTools → **Network** 中分别筛选 CSS 和 JS，观察每个页面加载的文件差异。

如没有安装 Python，可以使用 VS Code Live Server 或其他本地 HTTP 服务。示例中没有构建步骤、npm 依赖或数据库。

### 阶段 03：运行 WordPress 经典主题

1. 准备独立测试 WordPress，建议使用 **6.3 或更高版本**，以便演示脚本加载策略。
2. 将 `examples/03-wordpress-theme/wem-assets-demo/` 整个文件夹复制到 `wp-content/themes/`。
3. 在 **外观 → 主题** 中启用 `WEM Assets Demo`。
4. 建立并发布页面 `About`、`Products`、`Contact`，对应固定链接 slug 为 `about`、`products`、`contact`。
5. 给 Products 选择 **WEM Products Demo** 模板，给 Contact 选择 **WEM Contact Demo** 模板。
6. 在 **设置 → 阅读** 中设置静态首页，观察 `front-page.php` 的加载效果。
7. 验证菜单、首页按钮、产品筛选、联系表单本地提示；打开 Network 检查页面专属资源。

> 这个主题仅用于资源加载教学，不具备完整商业主题的模板、安全、SEO 或业务功能。联系表单**不会提交到服务器**，也不会存储任何数据。

## 5. 最重要的开发约定

| 分类 | 规范 | 原因 |
| --- | --- | --- |
| 目录 | `assets/css/`、`assets/js/` | 保持样式和行为分离 |
| 多页面 | `common.*` + `pages/*` | 共享代码集中，页面代码按需加载 |
| 第三方库 | 未来按需放入 `assets/vendor/` | 隔离第三方代码，锁定真实版本 |
| CSS | 类名清晰、作用域明确，避免滥用 `!important` | 降低跨页面覆盖风险 |
| JS | 按功能初始化，绑定事件前检查 DOM | 避免空元素异常及重复初始化 |
| 执行顺序 | 传统外部 JS 优先 `defer`，明确依赖 | 减少解析阻塞和顺序错误 |
| WordPress | 在 `wp_enqueue_scripts` 上统一 enqueue | 管理句柄、版本、依赖和页面条件 |
| WordPress 钩子 | 保留 `wp_head()`、`wp_body_open()`、`wp_footer()` | 允许核心、主题与插件正确输出内容 |
| 缓存 | 开发时验证真实请求，发布时管理文件版本 | 减少旧文件导致的误判 |
| 优化 | 先正确、后测量，再逐项优化 | 不为了评分破坏功能 |

### WordPress 资源加载入口

`functions.php` 只负责加载 `inc/enqueue.php`。`enqueue.php` 统一处理：

- 公共 CSS / JS 的全站加载。
- `is_front_page()`：首页资源。
- `is_page('products')`：产品演示页资源。
- `is_page('contact')`：联系演示页资源。
- 使用 `filemtime()` 作为**教学项目**的资源版本值；生产项目应根据部署流程选择稳定的发布版本或内容哈希策略。

**重要边界：** 示例中的条件使用固定 slug 是为了容易理解；真正复杂网站可以根据页面模板、内容类型、分类法及多语言策略调整条件判断。WordPress 的句柄去重不等于能识别不同 URL 引入的同一库。

## 6. 验收清单

- [ ] 五个 HTML 文件均有分层缩进，HTML 标签闭合正确。
- [ ] PHP 模板以清晰的 HTML 结构及 PHP 代码块组织。
- [ ] 单页面中 `style.css` / `main.js` 加载正常。
- [ ] 多页面公共导航可正常展开与收起。
- [ ] Home、Products、Contact 的页面脚本只在对应页面引入。
- [ ] About 不请求无用的页面专属 CSS / JS。
- [ ] WordPress 模板保留 `wp_head()`、`wp_body_open()`、`wp_footer()`。
- [ ] WordPress 管理员与游客前台行为一致。
- [ ] Console 无相关错误，Network 无资源 404。
- [ ] 不因资源缓存、优化插件而出现不同页面功能失效。

具体场景见 [三阶段演示与验收](docs/08-example-project.md)。

## 7. 文档阅读顺序

建议按以下主题学习：

1. 单页面 HTML：资源分离与引入方式。
2. CSS / JS 加载顺序、`defer`、`async`、第三方依赖与版本。
3. 多页面：公共资源、页面资源与组件复用。
4. CSS：命名、作用域、优先级与响应式。
5. JavaScript：事件监听、委托、初始化和多实例组件。
6. WordPress：enqueue、handle、依赖、条件加载与钩子。
7. 性能：DevTools、缓存、优化、安全和回归测试。
8. 三阶段完整示例与验收。

当前仓库包含 [八章知识体系提纲](docs/00-guide-outline.md) 和 [第 08 章可运行演示文档](docs/08-example-project.md)。**前七章的详细讨论尚未逐章转存成独立 Markdown 正文**，不要将目录提纲误认为完整章节文件。v1.0.0 封板范围是“基础规范、完整三阶段示例与使用说明”，而非完整教材出版版。

## 8. 适用范围与限制

- 示例聚焦 **WordPress 经典主题**，不涵盖区块主题的完整资源体系。
- 目前使用原生 JavaScript，无 jQuery、Bootstrap、Swiper、Fancybox 等外部依赖，以突出加载机制。未来加入第三方库时，先声明其版本和依赖，再添加实际示例。
- 多 HTML 页面的导航内容仍然重复，未引入模板引擎；这里只研究 CSS / JS 管理。
- `data-initialized` 等轻量机制不等同于复杂动态应用的完整组件生命周期。
- 线上运行前需根据真实业务补充安全、SEO、可访问性、错误处理与备份策略。

## 9. 版本与发布

**v1.0.0（2026-10-09）**

- 完成单 HTML、多 HTML 和 WordPress 经典主题三阶段示例。
- 将所有 HTML 页面与 PHP 模板整理为分层缩进的可读源码。
- 将 WordPress `enqueue.php` 的长参数调用展开为多行结构。
- 完善中文 README、操作步骤、规范、限制和验收清单。
- 保持阶段 02 与阶段 03 的 CSS / JS 文件一致，便于横向学习。

本仓库为学习与工程规范示例，不承诺适用于所有生产环境。建议先在测试站点验收，再将相同原则应用到实际新项目。

---

**记忆口诀：单页分离，多页复用，组件按需，WordPress 统一加载。**
