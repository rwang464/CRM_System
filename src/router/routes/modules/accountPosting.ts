import { DEFAULT_LAYOUT } from '../base';
import { AppRouteRecordRaw } from '../types';

const LIST: AppRouteRecordRaw = {
  path: '/accoutPosting',
  name: 'accout Posting',
  component: DEFAULT_LAYOUT,
  meta: {
    locale: 'menu.accountPosting',
    requiresAuth: true,
    icon: 'icon-list',
    order: 2,
  },
  children: [
    {
      path: 'search-table', // The midline path complies with SEO specifications
      name: 'Accout Posting',
      component: () => import('@/views/accountPosting/search-table/index.vue'),
      meta: {
        locale: 'menu.accountPosting.accountPostTable',
        requiresAuth: true,
        roles: ['*'],
      },
    },
  ],
};

export default LIST;
