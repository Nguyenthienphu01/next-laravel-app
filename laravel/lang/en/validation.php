<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attributeを承認してください。',
    'active_url'           => ':attributeは、有効なURLではありません。',
    'after'                => ':attributeには、:date以降の日付を指定してください。',
    'after_or_equal'       => ':attributeには、:date以降もしくは同日時を指定してください。',
    'alpha'                => ':attributeには、アルファベッドのみ使用できます。',
    'alpha_dash'           => ":attributeには、英数字('A-Z','a-z','0-9')とハイフンと下線('-','_')が使用できます。",
    'alpha_num'            => ":attributeには、英数字('A-Z','a-z','0-9')が使用できます。",
    'array'                => ':attributeには、配列を指定してください。',
    'before'               => ':attributeには、:date以前の日付を指定してください。',
    'before_or_equal'      => ':attributeには、:date以前もしくは同日時を指定してください。',
    'between'              => [
        'numeric' => ':attributeには、:minから、:maxまでの数字を指定してください。',
        'file'    => ':attributeには、:min KBから:max KBまでのサイズのファイルを指定してください。',
        'string'  => ':attributeは、:min文字から:max文字にしてください。',
        'array'   => ':attributeの項目は、:min個から:max個にしてください。',
    ],
    'boolean'              => ":attributeには、'true'か'false'を指定してください。",
    'confirmed'            => ':attributeと:attribute確認が一致しません。',
    'date'                 => ':attributeは、正しい日付ではありません。',
    'date_format'          => ":attributeの形式は、':format'と合いません。",
    'different'            => ':attributeと:otherには、異なるものを指定してください。',
    'digits'               => ':attributeは、:digits桁にしてください。',
    'digits_between'       => ':attributeは、:min桁から:max桁にしてください。',
    'dimensions'           => ':attributeは、正しい縦横比ではありません。',
    'distinct'             => ':attributeに重複した値があります。',
    'email'                => ':attributeの形式が正しくありません。',
    'exists'               => '選択された:attributeは、有効ではありません。',
    'file'                 => ':attributeはファイルでなければいけません。',
    'filled'               => ':attributeは必須です。',
    'image'                => ':attributeには、画像を指定してください。',
    'in'                   => '選択された:attributeは、有効ではありません。',
    'in_array'             => ':attributeは、:otherに存在しません。',
    'integer'              => ':attributeには、整数を指定してください。',
    'ip'                   => ':attributeには、有効なIPアドレスを指定してください。',
    'ipv4'                 => ':attributeはIPv4アドレスを指定してください。',
    'ipv6'                 => ':attributeはIPv6アドレスを指定してください。',
    'json'                 => ':attributeには、有効なJSON文字列を指定してください。',
    'max'                  => [
        'numeric' => ':attributeには、:max以下の数字を指定してください。',
        'file'    => ':attributeには、:max KB以下のファイルを指定してください。',
        'string'  => ':attributeは:max文字以内で入力してください。',
        'array'   => ':attributeの項目は、:max個以下にしてください。',
    ],
    'mimes'                => ':attributeには、:valuesタイプのファイルを指定してください。',
    'mimetypes'            => ':attributeには、:valuesタイプのファイルを指定してください。',
    'min'                  => [
        'numeric' => ':attributeには、:min以上の数字を指定してください。',
        'file'    => ':attributeには、:min KB以上のファイルを指定してください。',
        'string'  => ':attributeは半角英数字での:min文字以上入力してください。',
        'array'   => ':attributeの項目は、:max個以上にしてください。',
    ],
    'not_in'               => '選択された:attributeは、有効ではありません。',
    'numeric'              => ':attributeには、数字を指定してください。',
    'present'              => ':attributeは、必ず存在しなくてはいけません。',
    'regex'                => ':attributeには、有効な正規表現を指定してください。',
    'required'             => ':attributeを入力してください。',
    'required_if'          => ':otherが:valueの場合、:attributeを指定してください。',
    'required_unless'      => ':otherが:value以外の場合、:attributeを指定してください。',
    'required_with'        => ':valuesが指定されている場合、:attributeも指定してください。',
    'required_with_all'    => ':valuesが全て指定されている場合、:attributeも指定してください。',
    'required_without'     => ':valuesが指定されていない場合、:attributeを指定してください。',
    'required_without_all' => ':valuesが全て指定されていない場合、:attributeを指定してください。',
    'same'                 => ':attributeと:otherが一致しません。',
    'size'                 => [
        'numeric' => ':attributeには、:sizeを指定してください。',
        'file'    => ':attributeには、:size KBのファイルを指定してください。',
        'string'  => ':attributeは、:size文字にしてください。',
        'array'   => ':attributeの項目は、:size個にしてください。',
    ],
    'string'   => ':attributeには、文字を指定してください。',
    'timezone' => ':attributeには、有効なタイムゾーンを指定してください。',
    'unique'   => 'この:attributeは既に使われています。',
    'uploaded' => ':attributeのアップロードに失敗しました。',
    'url'      => ':attributeは、有効なURL形式で指定してください。',
    'is_json'              => ':attributeには、有効なJSON文字列を指定してください。',
    'duplicated' => 'すでに登録されるメールです。',
    'max_emoji' => ':attributeには、:max_emoji以下の数字を指定してください。',
    'custom' => [
        'coupon_public_start_date' => [
            'required_if' => '表示開始日時の形式が不正です。再度ご確認ください。',
            'required' => '表示開始日時の形式が不正です。再度ご確認ください。',
            'date' => '表示開始日時の形式が不正です。再度ご確認ください。',
            'date_format' => '表示開始日時の形式が不正です。再度ご確認ください。',
            'before_or_equal' => '表示期間内におさまる有効期間を指定してください。',
            'after_or_equal' => '表示開始日時を現日時より前に設定することはできません。',
        ],
        'coupon_public_end_date' => [
            'required_if' => '表示終了日時の形式が不正です。再度ご確認ください。',
            'required' => '表示終了日時の形式が不正です。再度ご確認ください。',
            'date' => '表示終了日時の形式が不正です。再度ご確認ください。',
            'date_format' => '表示終了日時の形式が不正です。再度ご確認ください。',
            'after_or_equal' => '表示期間内におさまる有効期間を指定してください。'
        ],
        'coupon_use_start_date' => [
            'required_if' => '有効開始日時の形式が不正です。再度ご確認ください。',
            'required' => '有効開始日時の形式が不正です。再度ご確認ください。',
            'date' => '有効開始日時の形式が不正です。再度ご確認ください。',
            'date_format' => '有効開始日時の形式が不正です。再度ご確認ください。',
            'after_or_equal' => '表示開始日時を現日時より前に設定することはできません。',
        ],
        'coupon_use_end_date' => [
            'required_if' => '有効終了日時の形式が不正です。再度ご確認ください。',
            'required' => '有効終了日時の形式が不正です。再度ご確認ください。',
            'date' => '有効終了日時の形式が不正です。再度ご確認ください。',
            'date_format' => '有効終了日時の形式が不正です。再度ご確認ください。',
            'after_or_equal' => '有効期間の開始日時は、有効期間の終了日時より過去または現在である必要があります。'
        ],
        'banner_content.*.image_url_path' => [
            'required_if' => '画像をアップロードしてください。'
        ],
        'banner_content.*.link_destination_url' => [
            'regex' => 'リンク先URLの形式が正しくありません。'
        ],
        'banner_content.*.is_public' => [
            'boolean' => 'リクエストが不正です。開発チームに連携してください。（公開設定の値は対象外に設定しています）'
        ],
        'coupon_details' => [
            'max_emoji' => 'クーポン詳細説明は:max_emoji文字（改行は1文字としてカウントされ、絵文字は2文字としてカウントします）以内で入力してください。'
        ],
        'store_code' => [
            'regex' => '店コードは半角数字、4文字以内で入力してください。',
        ],
        'prefecture_code' => [
            'required' => '都道府県を選択してください。',
        ],
        'tsunagaru_url' => [
            'url' => '「TSUNAGARUの計測URL」が正しい形式ではありません。',
        ],
        'memo' => [
            'max' => '管理用メモは100文字以内で入力してください。',
        ],
        'staff_code' => [
            'regex' => '社員番号は半角英数字、7文字以内で入力してください。',
            'required_with' => '社員番号を入力してください。',
        ],
        'csv_url' => [
            'required' => 'CSV形式のファイルをアップロードしてください。',
        ],
        'email' => [
            'regex' => 'メールアドレスの形式が正しくありません。',
            'email' => 'メールアドレスの形式が正しくありません。',
            'unique' => 'このアカウントが既に存在していますので、他のメールアドレスでお試しください。',
        ],
        'is_law_compliance' => [
            'required' => 'リクエストが不正です。開発チームに連絡してください。（景品表示法確認の値が対象外になります）',
            'boolean' => 'リクエストが不正です。開発チームに連絡してください。（景品表示法確認の値が対象外になります）',
            'accepted' => 'リクエストが不正です。開発チームに連絡してください。（景品表示法確認の値が対象外になります）'
        ],
        'category_id' => [
            'required' => 'リクエストが不正です。開発チームに連絡してください。（カテゴリは必須です）',
            'integer' => 'リクエストが不正です。開発チームに連絡してください。（カテゴリの値は対象外に設定しています）',
            'between' => 'リクエストが不正です。開発チームに連絡してください。（カテゴリの値は対象外に設定しています）'
        ],
        'status' => [
            'required' => 'リクエストが不正です。開発チームに連絡してください。（ユーザー利用状態の値を設定していません）',
            'in' => 'リクエストが不正です。開発チームに連絡してください。（ユーザー利用状態の値を範囲外に設定しています）'
        ],
        'role' => [
            'required' => 'リクエストが不正です。開発チームに連絡してください。（ユーザー権限の値を設定していません）',
            'in' => 'リクエストが不正です。開発チームに連絡してください。（ユーザー権限の値を範囲外に設定しています）'
        ],
        'user_id' => [
            'required' => 'アカウントの削除を失敗しました。',
            'exists' => 'このアカウントは存在しません。',
        ],
        'coupon_type' => [
            'required' => 'リクエストが不正です。開発チームに連絡してください。（クーポン種別は必須です）',
            'numeric' => 'リクエストが不正です。開発チームに連絡してください。（クーポン種別の値は対象外に設定しています）',
            'in' => 'リクエストが不正です。開発チームに連絡してください。（クーポン種別の値は対象外に設定しています）'
        ],
        'lottery_coupon_settings.*.probability_winning' => [
            'between' => '確率が合計で100％になっていません。100%になるように入力してください。'
        ],
        'lottery_coupon_settings.*.display_text' => [
            'max_emoji' => '表示テキストは12文字以内で入力してください。'
        ],
        'lottery_coupon_settings.*.display_message' => [
            'max_emoji' => '表示メッセージは45文字以内で入力してください。'
        ],
        'subscription_public_start_date' => [
            'required_if' => '可能開始日時の形式が不正です。再度ご確認ください。',
            'required' => '可能開始日時の形式が不正です。再度ご確認ください。',
            'date' => '可能開始日時の形式が不正です。再度ご確認ください。',
            'date_format' => '可能開始日時の形式が不正です。再度ご確認ください。',
            'before_or_equal' => '表示期間内におさまる申込み可能期間を指定してください。',
            'after_or_equal' => '表示開始日時を現日時より前に設定することはできません。',
        ],
        'subscription_public_end_date' => [
            'required_if' => '可能終了日時の形式が不正です。再度ご確認ください。',
            'required' => '可能終了日時の形式が不正です。再度ご確認ください。',
            'date' => '可能終了日時の形式が不正です。再度ご確認ください。',
            'date_format' => '可能終了日時の形式が不正です。再度ご確認ください。',
            'after_or_equal' => '表示期間内におさまる有効期間を指定してください。'
        ],
        'subscription_use_start_date' => [
            'required_if' => '可能開始日時の形式が不正です。再度ご確認ください。',
            'required' => '可能開始日時の形式が不正です。再度ご確認ください。',
            'date' => '可能開始日時の形式が不正です。再度ご確認ください。',
            'date_format' => '可能開始日時の形式が不正です。再度ご確認ください。',
            'after_or_equal' => '表示開始日時を現日時より前に設定することはできません。',
        ],
        'subscription_use_end_date' => [
            'required_if' => '可能終了日時の形式が不正です。再度ご確認ください。',
            'required' => '可能終了日時の形式が不正です。再度ご確認ください。',
            'date' => '可能終了日時の形式が不正です。再度ご確認ください。',
            'date_format' => '可能終了日時の形式が不正です。再度ご確認ください。',
            'after_or_equal' => '可能期間の開始日時は、可能期間の終了日時より過去または現在である必要があります。'
        ],
        'csv_url_path' => [
            'required_if' => 'CSV形式のファイルをアップロードしてください。',
            'required' => 'CSV形式のファイルをアップロードしてください。',
        ],
        'user_ids' => [
            'required_if' => 'フォーマットが正しくありません。指定フォーマットのCSV形式のファイルをアップロードしてください。',
            'required' => 'フォーマットが正しくありません。指定フォーマットのCSV形式のファイルをアップロードしてください。',
        ],
        'subscription_coupons.*.coupon_id' => [
            'required' => 'リクエストが不正です。開発チームに連絡してください。（クーポンIDを設定していません）',
            'integer' => 'リクエストが不正です。開発チームに連絡してください。（クーポンIDを設定していません）',
            'min' => 'リクエストが不正です。開発チームに連絡してください。（クーポンIDを設定していません）'
        ],
        'subscription_coupons.*.quantity' => [
            'required' => '枚数を選択してください。',
            'integer' => '枚数は半角英数字の2桁（1から99まで）を入力してください。',
            'between' => '枚数は半角英数字の2桁（1から99まで）を入力してください。'
        ],
        'registration_message' => [
            'max_emoji' => '登録完了後メッセージは:max_emoji文字（改行は1文字としてカウントされ、絵文字は2文字としてカウントします）以内で入力してください。',
        ],
        'cancel_message' => [
            'max_emoji' => '解約時メッセージは:max_emoji文字（改行は1文字としてカウントされ、絵文字は2文字としてカウントします）以内で入力してください。',
        ],
        'explanation' => [
            'max_emoji' => 'サブスク詳細説明は:max_emoji文字（改行は1文字としてカウントされ、絵文字は2文字としてカウントします）以内で入力してください。'
        ],
        'limit' => [
            'integer' => 'リクエストのパラメーターが不正です。（リミット数の値は1以上の数字ではないものを設定しています）',
            'min' => 'リクエストのパラメーターが不正です。（リミット数の値は1以上の数字ではないものを設定しています）',
            'in' => 'リクエストのパラメーターが不正です。（リミット数の値は[10、 20、50]以外を設定しています）',
        ],
        'page' => [
            'integer' => 'リクエストのパラメーターが不正です。（ページ数の値は1以上の数字ではないものを設定しています）',
            'min' => 'リクエストのパラメーターが不正です。（ページ数の値は1以上の数字ではないものを設定しています）',
        ],
        'subscription_category_id' => [
            'required' => 'リクエストが不正です。開発チームに連絡してください。（カテゴリは必須です）',
            'integer' => 'リクエストが不正です。開発チームに連絡してください。（カテゴリは必須です）',
            'between' => 'リクエストが不正です。開発チームに連絡してください。（カテゴリの値は対象外に設定しています）',
        ],
        'fee' => [
            'required' => '料金を入力してください。',
            'integer' => '料金は半角英数字を入力してください。',
            'min' => '料金は30,000円以下で入力してください。',
            'max' => '料金は30,000円以下で入力してください。'
        ],
        'storeId' => [
            'required_if' => '店舗管理者を設定しているユーザーは店コードを入力してください。',
            'exists' => '店舗管理者を設定しているユーザーの店コードが DB に存在しないか、正しい形式ではありません。',
        ],
        'userId' => [
            'exists' => 'リクエストが不正です。開発チームに連絡してください。（このアカウントは存在しません。）',
        ],
        // attributes for email row from csv
        '*.0' => [
            'required' => '性列にデータがありません。',
            'max'                  => [
                'string'  => '性列の値は:max文字以内で入力してください。',
            ],
        ],
        '*.1' => [
            'required' => '名列にデータがありません。',
            'max'                  => [
                'string'  => '名列の値は:max文字以内で入力してください。',
            ],
        ],
        '*.2' => [
            'required' => 'メールアドレス列にデータがありません。',
            'email' => 'メールアドレス列の形式が正しくありません。',
            'regex' => 'メールアドレス列の形式が正しくありません。',
            'unique' => 'メールアドレスの列に重複したデータが既に存在されていますので、他のメールアドレスでお試してください。',
        ],
        '*.3' => [
            'required' => '店コードを指定してください。',
            'regex' => 'パスワード列の値は半角英数字、8-20文字以内で入力してください。',
            'min' => 'パスワード列の値は半角英数字、8-20文字以内で入力してください。',
            'max' => 'パスワード列の値は半角英数字、8-20文字以内で入力してください。',
        ],
        '*.4' => [
            'required' => '権限列にデータがありません。',
            'in' => '権限の値を範囲外に設定しています。',
        ],
        '*.5' => [
            'required_if' => '店コード列にデータがありません。',
            'numeric' => '店コード列の値は半角英数字ではありません。',
            'max' => '店コード列の値は半角英数字、:max文字以内で入力してください。',
            'regex' => '店コード列の値は半角英数字、4文字以内で入力してください。',
            'exists' => '店コード列にデータがありません。',
        ],
        '*.6' => [
            'required_if' => '店舗名列にデータがありません。',
            'max' => '店舗名列の値は:max文字以内で入力してください。',
            'exists' => '店舗名列の値を見つかりません。',
        ],
        '*.7' => [
            'required' => '状態列にデータがありません。',
            'in' => '状態の値を範囲外に設定しています。',
        ],
    ],
    'fullwidth' => ':attributeは半角英数字で入力してください。',
    'min_pass' => ':attributeは半角英数字、' . config('constants.PASSWORD_MIN_LENGTH') . '文字以上' . config('constants.PASSWORD_MAX_LENGTH') . '文字以内で入力してください。',
    'max_pass' => ':attributeは半角英数字、' . config('constants.PASSWORD_MIN_LENGTH') . '文字以上' . config('constants.PASSWORD_MAX_LENGTH') . '文字以内で入力してください。',
    // set attibutes japanese text
    'attributes' => array(
        'store_code' => '店コード',
        'store_name' => '店舗名',
        'plan_id' => 'ブランド名',
        'services' => '提供サービス',
        'services.*' => '提供サービス',
        'phone' => '電話番号',
        'tsunagaru_url' => '「TSUNAGARUの計測URL」',
        'staffs' => 'スタッフ番号',
        'staffs.*.staff_code' => 'スタッフ番号',
        'staffs.*.memo' => '管理用メモ',
        'lastname' => '氏名（名）',
        'firstname' => '氏名（姓）',
        'status' => '状態',
        'password' => 'パスワード',
        'email' => 'メールアドレス',
        'role' => '権限',
        'banner_content.*.banner_name' => '管理用バナー名',
        'admin_title' => '管理用タイトル',
        'admin_remarks' => '備考',
        'keywords' => '検索キーワード',
        'coupon_name' => 'クーポン名',
        'coupon_details' => '',
        'account' => '',
        'user_id' => '',
        'subscription_name' => 'サブスク名',
        'storeId' => '店舗管理者',
    ),
];
