import { reactive } from 'vue';
import i18n from '@/config/i18n';

export function useValidationsRules() {
  const { t } = i18n.global;
  const lowerCase = /(?=.*[a-z])/;
  const upperCase = /(?=.*[A-Z])/;
  const digit = /(?=.*\d)/;
  const symbol = /(?=.*\W)/;
  const noSpace = /^[^ ]+$/;
  const email = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
  const phone = /^(?=.*[0-9])[- +()0-9]+$/; //matches numbers, spaces, plus sign, hyphen and brackets
  const linkRegex = /^(http(s)?:\/\/)?([\w-]+\.)+[\w-]+(\/[\w-.\/?%&=]*)?$/;

  const rules = reactive({
    required: [(value?: any) => !isEmpty(value) || t('required')],
    email: [(value?: string) => isEmail(value) || t('invalidEmail')],
    isEmailOrPhone: [(value?: string) => isEmailOrPhone(value) || t('invalidInput')],
    minLength: (min: number, value?: any) => {
      if (!!value && value.toString().length < min) {
        return t('minLength', min);
      }
      return true;
    },
    complexPassword: (value?: any) => {
      if (value) {
        if (value.toString().length < 10) {
          return t('minPasswordLength');
        }
        if (!noSpace.test(value)) {
          return t('noSpace');
        }

        if (!lowerCase.test(value)) {
          return t('minOneLowerCase');
        }
        if (!upperCase.test(value)) {
          return t('minOneUpperCase');
        }
        if (!digit.test(value)) {
          return t('minOneNumericCase');
        }
        if (!symbol.test(value)) {
          return t('minOneSpecialChar');
        }
      }
      return true;
    },
    confirmPassword: (valueOne?: any, valueTwo?: any) => {
      if (valueOne !== valueTwo) {
        return t('passwordNotMatch');
      }
    },
    link: [(value?: string) => isLink(value) || t('invalidLink')]
  });

  const isEmpty = (value?: any) => {
    if (!!value && typeof value === 'object') {
      return Object.keys(value).length > 0;
    }
    const falsy = ['', null, undefined];
    return falsy.includes(value);
  };

  const isEmail = (value?: string) => {
    if (!isEmpty(value) && typeof value === 'string') {
      return email.test(value);
    }
    return false;
  };

  const isLink = (value?: string) => {
    // link validation
    if (value) {
      if (!value.startsWith('http://') && !value.startsWith('https://')) {
        return false;
      }
      return linkRegex.test(value);
    }
    return true;
  };

  const isEmailOrPhone = (value?: string) => {
    if (!isEmpty(value) && typeof value === 'string' && (email.test(value) || phone.test(value))) {
      return true;
    }
    return false;
  };

  const validate = async (form?: any) => {
    const r = await form.value.validate();
    return r.valid;
  };
  return { rules, validate };
}
