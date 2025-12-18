import { createI18n } from 'vue-i18n';
import en from '../lang/en.json';
import vn from '../lang/vn.json';

export const messages = {
    en,
    vn,
};

export const createI18nInstance = (locale = 'en') =>
    createI18n({
        legacy: false,
        locale,
        fallbackLocale: 'en',
        messages,
    });
