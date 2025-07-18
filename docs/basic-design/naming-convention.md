# 📐 命名規則 - Naming Convention

## バックエンド

### Laravelの命名規則に準拠

- PHP - PSR-4、PSR-12に準拠
- また、Laravelコミュニティに受け入れられた命名規則に従います。

| 対象 | 規則 | Good | Bad |
|------|------|------|-----|
| コントローラ | 単数形 | ArticleController | ArticlesController |
| ルート | 複数形 | articles/1 | article/1 |
| 名前付きルート | スネークケースとドット表記 | users.show_active | users.show-active, show-active-users |
| モデル | 単数形 | User | Users |
| hasOne または belongsTo 関係 | 単数形 | articleComment | articleComments, article_comment |
| その他すべての関係 | 複数形 | articleComments | articleComment, article_comments |
| テーブル | 複数形 | article_comments | article_comment, articleComments |
| Pivotテーブル | 単数形 モデル名のアルファベット順 | article_user | user_article, articles_users |
| テーブルカラム | スネークケース モデル名は含めない | meta_title | MetaTitle; article_meta_title |
| モデルプロパティ | スネークケース | $model->created_at | $model->createdAt |
| 外部キー | 単数形 モデル名の最後に_idをつける | article_id | ArticleId, id_article, articles_id |
| 主キー | - | id | custom_id |
| マイグレーション | - | 2017_01_01_000000_create_articles_table | 2017_01_01_000000_articles |
| メソッド | キャメルケース | getAll | get_all |
| リソースコントローラのメソッド | 一覧 | store | saveArticle |
| テストクラスのメソッド | スネークケース | test_guest_cannot_see_article | testGuestCannotSeeArticle |
| 変数 | キャメルケース | $articlesWithAuthor | $articles_with_author |
| コレクション | 説明的、 複数形 | $activeUsers = User::active()->get() | $active, $data |
| オブジェクト | 説明的, 単数形 | $activeUser = User::active()->first() | $users, $obj |
| 設定ファイルと言語ファイルのインデックス | スネークケース | articles_enabled | ArticlesEnabled; articles-enabled |
| ビュー | ケバブケース | show-filtered.blade.php | showFiltered.blade.php, show_filtered.blade.php |
| コンフィグ | スネークケース | google_calendar.php | googleCalendar.php, google-calendar.php |
| 契約 (インターフェイス) | 形容詞または名詞 | AuthenticationInterface | Authenticatable, IAuthentication |
| Trait | 形容詞 | Notifiable | NotificationTrait |
| Trait (PSR) | adjective | NotifiableTrait | Notification |
| Enum | singular | UserType | UserTypes, UserTypeEnum |
| FormRequest | singular | UpdateUserRequest | UpdateUserFormRequest, UserFormRequest, UserRequest |
| Seeder | singular | UserSeeder | UsersSeeder |

## フロントエンド

### Vue.jsの命名規則に準拠

| 対象 | 規則 | Good | Bad |
|------|------|------|-----|
| コンポーネント名 | パスカルケース、複数単語 | TodoItem, TodoList | todoItem, todo_item, Todo |
| プロップス | キャメルケース | todoItem, isComplete | TodoItem, is-complete |
| イベント名 | ケバブケース | click, focus-in | onClick, onFocusIn |
| データプロパティ | キャメルケース | userId, isActive | UserID, is_active |
| メソッド名 | キャメルケース | getUserData, setActiveState | get_user_data, SetActiveState |
| 算出プロパティ | キャメルケース | fullName, totalPrice | full_name, TotalPrice |
| プライベートプロパティ/メソッド | 先頭にアンダースコア、キャメルケース | _privateMethod, _hiddenProperty | privateMethod, hidden_property |
| ディレクティブ | ケバブケース | v-bind, v-on | vBind, v_on |
| カスタムディレクティブ | ケバブケース | v-my-directive | vMyDirective, v_my_directive |
| Mixin名 | キャメルケース | myMixin, userAuthMixin | MyMixin, user-auth-mixin |
| Vuexストア内のモジュール名 | キャメルケース | userModule, cartModule | UserModule, cart_module |
| Vuexのアクション名 | キャメルケース | fetchUsers, updateProfile | FETCH_USERS, update-profile |
| Vuexのミューテーション名 | スネークケース（大文字） | SET_USER, UPDATE_PROFILE | setUser, update-profile |
| テンプレート内の参照 | キャメルケース | todoItem, userProfile | todo-item, UserProfile |
| ファイル名（単一ファイルコンポーネント） | パスカルケースまたはケバブケース | TodoList.vue, todo-list.vue | todoList.vue, Todo_List.vue |
| プラグイン名 | キャメルケース | myPlugin, vueRouter | MyPlugin, vue-router |
