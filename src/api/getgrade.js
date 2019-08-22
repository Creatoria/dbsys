import request from '@/utils/request'

export function getList(params) {
  return request({
    url: '/stu/getgrade',
    method: 'get',
    params
  })
}
