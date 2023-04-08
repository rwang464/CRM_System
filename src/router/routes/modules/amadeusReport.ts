import { DEFAULT_LAYOUT } from '../base';
import { AppRouteRecordRaw } from '../types';

const LIST: AppRouteRecordRaw = {
  path: '/amadeusReport',
  name: 'amadeus Posting',
  component: DEFAULT_LAYOUT,
  meta: {
    locale: 'menu.amadeusReport',
    requiresAuth: true,
    icon: 'icon-list',
    order: 2,
  },
  children: [
    {
      path: 'search-table', // The midline path complies with SEO specifications
      name: 'Amadeus Posting',
      component: () => import('@/views/amadeusReport/search-table/index.vue'),
      meta: {
        locale: 'menu.amadeusReport.amadeusReportTable',
        requiresAuth: true,
        roles: ['*'],
      },
    },
  ],
};

export default LIST;
