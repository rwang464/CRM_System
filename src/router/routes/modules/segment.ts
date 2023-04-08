import { DEFAULT_LAYOUT } from '../base';
import { AppRouteRecordRaw } from '../types';

const LIST: AppRouteRecordRaw = {
  path: '/segment',
  name: 'segment',
  component: DEFAULT_LAYOUT,
  meta: {
    locale: 'menu.segment',
    requiresAuth: true,
    icon: 'icon-list',
    order: 2,
  },
  children: [
    {
      path: 'search-table', // The midline path complies with SEO specifications
      name: 'Segment',
      component: () => import('@/views/segment/search-table/index.vue'),
      meta: {
        locale: 'menu.segment.segmentTable',
        requiresAuth: true,
        roles: ['*'],
      },
    },
  ],
};

export default LIST;
