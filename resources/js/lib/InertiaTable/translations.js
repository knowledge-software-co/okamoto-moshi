const translationsObject = {
    translations: {
        // next: "Next",
        // no_results_found: "No results found",
        // of: "of",
        // per_page: "per page",
        // previous: "Previous",
        // results: "results",
        // to: "to"
        next: '次へ',
        no_results_found: 'データはありません。',
        of: '件',
        per_page: '件 / ページ',
        previous: '前へ',
        results: '件中',
        to: '〜',
    }
};

export default translationsObject.translations;

export function getTranslations() {
    return translationsObject.translations;
}

export function setTranslation(key, value) {
    translationsObject.translations[key] = value;
}

export function setTranslations(translations) {
    translationsObject.translations = translations;
}
