# 从 HTML 到 WordPress：CSS / JavaScript 资源组织与加载规范

> **v1.2.0 · 前端资源管理速查工作台 + 三阶段可运行教学示例**  
> 面向从静态 HTML 开始建设网站，逐步扩展多页面，最终迁移到 WordPress 经典主题的开发者。

**核心口诀：单页分离，多页复用，组件按需，WordPress 统一加载。**

## 📖 快速入口

| 入口 | 用途 |
| --- | --- |
| **[打开前端资源管理速查工作台](index.html)** | 日常建站速查：规范、对照表、可复制代码、错误排查与验收清单 |
| [单页面 HTML 示例](examples/01-single-html/index.html) | 理解 HTML / CSS / JS 分离和 `defer` |
| [多页面 HTML 示例](examples/02-multiple-html/index.html) | 理解 `common.*`、`pages/*` 与页面按需加载 |
| [WordPress 经典主题示例](examples/03-wordpress-theme/wem-assets-demo/) | 查看 enqueue、依赖、条件加载和主题模板 |
| [三阶段演示与验收文档](docs/08-example-project.md) | 按步骤运行并检查示例结果 |
| [八章知识体系提纲](docs/00-guide-outline.md) | 查看学习主题和内容边界 |
| [v1.2.0 Release](https://github.com/coowinit/html-to-wordpress-assets-guide/releases/tag/v1.2.0) | 查看当前正式版发布信息 |

**使用建议：** 平时建站需要查代码，优先打开根目录 `index.html`；需要理解原理或测试运行效果，再进入 `examples/` 和 `docs/`。这样不必每次从头阅读整份 README。

> GitHub 网页中点击 `index.html` 通常显示源文件；要在浏览器中实际运行页面，可下载后本地打开，或在仓库 Settings → Pages 中启用 GitHub Pages（`main` 分支、根目录 `/`）。配置成功后，预计地址为 `https://coowinit.github.io/html-to-wordpress-assets-guide/`。该地址是否已上线，以 Pages 实际部署状态为准。

## 1. 项目解决什么问题？

最初开发单个 HTML 页面时，把 CSS 和 JavaScript 直接写入页面很方便；但页面增多后，重复代码、文件加载顺序、第三方依赖、缓存及不同页面之间的脚本冲突，会显著增加维护成本。

本项目的目标**不是重构旧 WordPress 主题**，而是建立从新项目开始就能沿用的资源管理方法：

- 单页面阶段：先把功能做正确，分清 HTML、CSS、JavaScript 各自的职责。
- 多页面阶段：共享资源集中管理，页面专属资源按需加载。
- WordPress 阶段：尽可能复用原有 CSS / JS，把加载入口交给 `wp_enqueue_style()` / `wp_enqueue_script()`。
- 调试和发布阶段：先检查真实请求与依赖关系，再处理缓存、优化和性能问题。

**原则：先正确、再验证、后优化；不为了目录整齐或性能评分而过度设计。**

## 2. v1.2.0 速查工作台

仓库根目录的 [`index.html`](index.html) 是一个**单文件静态速查页面**：用于阅读的 CSS 和 JavaScript 均内联其中，不依赖 npm、数据库、构建工具或 WordPress 环境。

它提供八个日常高频模块：

| 模块 | 查阅重点 |
| --- | --- |
| 01 · 总览与路径 | 单页面 → 多页面 → WordPress 的演进关系 |
| 02 · 目录结构 | `assets/css/`、`assets/js/`、`common.*`、`pages/*` |
| 03 · 加载规则 | `<link>`、`defer`、`async`、`type="module"` |
| 04 · 页面资源矩阵 | Home、About、Products、Contact 应加载哪些资源 |
| 05 · WordPress enqueue | 公共资源、首页/页面条件、主题钩子、PHP → JS 数据 |
| 06 · 第三方库与依赖 | jQuery、Swiper 等库的版本、依赖和按需加载原则 |
| 07 · 缓存与错误排查 | Console、Network、资源版本、WP Rocket / Cloudflare 等优化环境 |
| 08 · 发布验收清单 | 勾选进度、本地保存、复制 Markdown 检查结果 |

**页面交互：** 支持关键词搜索、代码标签切换、一键复制、移动端目录、返回顶部、打印样式和检查清单状态保存。清单使用浏览器 `localStorage`，记录保存在当前浏览器环境中，**不会自动同步到其他设备或项目**。

**特别说明：** 这里的“单文件”仅指**速查工作台本身的交付形式**，并不是建议生产网站把全部 CSS / JS 都塞进 HTML。下方三个教学阶段仍按照资源分离与复用原则组织文件。

## 3. 三阶段示例对照

| 阶段 | 源码位置 | 核心目标 | 加载方式 |
| --- | --- | --- | --- |
| 01 · 单页面 | [`examples/01-single-html/`](examples/01-single-html/) | HTML、CSS、JS 分离 | `style.css` + `main.js`，原生 `defer` |
| 02 · 多页面 | [`examples/02-multiple-html/`](examples/02-multiple-html/) | 公共资源与页面资源拆分 | `common.*` + 按需 `pages/*` |
| 03 · WordPress | [`examples/03-wordpress-theme/wem-assets-demo/`](examples/03-wordpress-theme/wem-assets-demo/) | 样式/脚本保持复用，WordPress 管理加载 | `wp_enqueue_style()` / `wp_enqueue_script()` |

**关键对照：** 阶段 02 与阶段 03 使用相同的 CSS / JS 文件；变化主要集中在 HTML / PHP 模板和 `inc/enqueue.php`。这能帮助区分“页面功能代码”和“资源加载机制”。

## 4. 仓库目录

```text
html-to-wordpress-assets-guide/
├── index.html                       # v1.2.0 单文件速查工作台（内联 CSS / JS）
├── README.md                        # 项目介绍、运行步骤与使用边界
├── docs/
│   ├── 00-guide-outline.md         # 八章知识体系提纲
│   └── 08-example-project.md       # 三阶段示例与验收
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
            └── assets/             # 与阶段 02 相同的 CSS / JS 文件
```

`assets/vendor/` 是未来接入第三方库时可考虑的目录约定，**不是当前教学示例已经存在的文件夹**。

## 5. 本地运行

### 5.1 速查工作台

直接双击仓库根目录的 `index.html` 即可查看。它本身不需要 PHP 或构建步骤。若希望统一通过 HTTP 方式查看，可在仓库根目录使用 PowerShell：

```powershell
py -m http.server 8000
```

随后在浏览器打开 `http://localhost:8000/`；按 `Ctrl+C` 停止服务器。也可以使用 VS Code Live Server。

### 5.2 单页面 HTML 示例

在仓库根目录执行：

```powershell
cd examples/01-single-html
py -m http.server 8000
```

访问 `http://localhost:8000/`，观察 `style.css` 与 `main.js` 的加载及交互。停止服务器后，返回仓库根目录再运行下一阶段。

### 5.3 多页面 HTML 示例

在仓库根目录执行：

```powershell
cd examples/02-multiple-html
py -m http.server 8000
```

测试 `index.html`、`about.html`、`products.html`、`contact.html`。通过 Chrome DevTools → **Network → CSS / JS** 检查公共资源和专属资源的请求差异：About 不需要单独的页面 JS 文件。

### 5.4 WordPress 经典主题示例

1. 准备独立的 WordPress 测试环境，建议 **WordPress 6.3 或更高版本**，以使用示例中的 `strategy => 'defer'` 脚本加载参数。
2. 将 `examples/03-wordpress-theme/wem-assets-demo/` 完整复制到 `wp-content/themes/`。
3. 在 WordPress 后台 **外观 → 主题** 中启用 `WEM Assets Demo`。
4. 建立并发布 `About`、`Products`、`Contact` 页面，slug 分别为 `about`、`products`、`contact`。
5. 为 Products 选择 **WEM Products Demo** 模板，为 Contact 选择 **WEM Contact Demo** 模板。
6. 在 **设置 → 阅读** 中设置静态首页，检查 `front-page.php` 的显示和资源加载。
7. 验证导航、首页按钮、产品筛选和联系表单提示，并通过 Network 检查条件加载。

> 该主题**仅用于资源管理教学**，不具备完整商业主题所需的 SEO、安全、无障碍和业务能力。联系表单只进行本地演示，**不会向服务器提交或存储数据**。

## 6. 开发规范速查

| 范围 | 约定 | 目的 |
| --- | --- | --- |
| 资源组织 | `assets/css/`、`assets/js/` | 分清样式与行为 |
| 多页面复用 | `common.*` + `pages/*` | 避免每页重复、按需加载 |
| 第三方库 | 按需放置 `assets/vendor/`，记录真实版本 | 便于排查依赖和冲突 |
| CSS | 明确作用域，减少无必要的 `!important` | 降低样式相互覆盖 |
| JS | 初始化前检查 DOM，避免无效绑定和重复初始化 | 减少 `null`、重复事件等错误 |
| 执行顺序 | 原生经典脚本按情况使用 `defer`，明确依赖 | 避免执行顺序问题 |
| WordPress | 统一通过 `wp_enqueue_scripts` 管理前台资源 | 管理 handle、deps、版本与页面条件 |
| 主题钩子 | 正确保留 `wp_head()`、`wp_body_open()`、`wp_footer()` | 允许核心及插件注入必要内容 |
| 缓存 | 检查实际请求 URL、响应和资源版本 | 避免误判旧缓存为代码故障 |
| 优化 | 先验证正确性，再测量和优化 | 避免优化插件破坏依赖与交互 |

### WordPress enqueue 的边界

示例中，`functions.php` 引入 `inc/enqueue.php`，由后者集中处理公共资源、首页资源及 Products、Contact 页面资源。其条件主要包括：

- `is_front_page()`：首页专属资源；
- `is_page('products')`：Products 示例页；
- `is_page('contact')`：Contact 示例页。

仓库使用基于 `filemtime()` 的版本辅助函数，适合说明缓存失效机制；生产站点应根据部署流程选择发布版本或构建哈希。`strategy` 参数需要 **WordPress 6.3+**；旧版 `in_footer=true` 只控制脚本放置位置，不等于 `defer`。

真实多语言网站或复杂内容模型不宜机械复制示例的固定 slug；可考虑页面模板、内容类型及可靠的业务判断条件。WordPress 的 handle 去重也不等于能识别两个不同 URL 加载的是同一第三方库。

## 7. 验收要点

完成示例后，至少检查：

- [ ] 单页面 HTML 能正确加载 CSS / JS，页面交互正常。
- [ ] 多页面公共导航正常；页面专属资源仅在需要的位置加载。
- [ ] About 页面无不必要的页面专属 CSS / JS 请求。
- [ ] WordPress 三个关键主题钩子保留且位置正确。
- [ ] WordPress 公共资源、首页资源和页面资源的条件加载符合预期。
- [ ] 管理员和游客的前台行为一致。
- [ ] Console 无相关异常，Network 无资源 404。
- [ ] 启用优化插件和 CDN 后，依赖顺序、缓存和页面交互仍然正常。
- [ ] 根目录速查页面的搜索、复制、标签切换、移动端导航与检查清单可以使用。

完整操作步骤见 [`docs/08-example-project.md`](docs/08-example-project.md)；速查工作台的第 08 模块也提供可保存和复制的发布检查清单。

## 8. 文档范围与已知限制

- **经典主题为主：** 不涵盖 WordPress 区块主题的完整资源体系。
- **零构建依赖：** 示例使用原生 HTML、CSS、JavaScript，无需 npm；不提供 Vite / Webpack 的完整实施方案。
- **第三方库为概念说明：** 速查页面会讨论 jQuery、Bootstrap、Swiper、Fancybox 等依赖原则，但运行示例并未安装这些库，也没有演示完整插件集成。
- **前七章仍是提纲：** [`docs/00-guide-outline.md`](docs/00-guide-outline.md) 是知识体系提纲，不代表第 01～07 章已有独立、完整的 Markdown 教材；现有完整教学侧重三阶段示例和第 08 章验收。
- **多页面 HTML 不使用模板引擎：** 导航内容仍有重复，这次研究只聚焦 CSS / JS 管理，不额外引入组件编译系统。
- **单文件工作台不等于生产推荐结构：** 根目录 `index.html` 为方便速查而内联资源；正式多页面或 WordPress 项目仍按职责组织 CSS / JS。
- **上线前须补齐业务要求：** 商业项目仍需要单独评估安全、SEO、可访问性、表单服务端校验、错误处理及备份。

## 9. 版本记录

### [v1.2.0](https://github.com/coowinit/html-to-wordpress-assets-guide/releases/tag/v1.2.0) · 2026-10-10

- 增加根目录 `index.html` 前端资源管理速查工作台，HTML / CSS / JS 集成在单个静态文件中。
- 整合八个高频速查模块，提供代码切换、复制、搜索、故障排查、移动端适配与发布验收清单。
- 补充 WordPress 6.3+ 脚本加载策略说明、版本管理辅助函数示例、样式 `media` 参数及 PHP → JS 安全边界提示。
- 调整验收清单内容，支持复制为 GitHub Markdown 任务清单。
- 保留原有三阶段独立示例，明确速查页面和教学示例的不同职责。

### v1.0.0 · 2026-10-09

- 完成单页面 HTML、多页面 HTML 和 WordPress 经典主题三阶段可运行示例。
- 规范化 HTML 页面和 PHP 模板缩进，保持源码可读性。
- 完善 `inc/enqueue.php`、中文 README、运行步骤及验收说明。
- 保持阶段 02 与阶段 03 的 CSS / JS 文件一致，便于对照学习。

---

**记忆口诀：单页分离，多页复用，组件按需，WordPress 统一加载。**

本仓库用于学习和工程实践参考。请先在测试环境验证，再根据实际站点的主题、插件、多语言、缓存和部署方式应用相关原则。
