import request from '@/utils/request'

export function getList(params) {
  return request({
    url: '/sysdata/list',
    method: 'get',
    params
  })
}
