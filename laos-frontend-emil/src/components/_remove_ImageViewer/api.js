import Vue from 'vue'
import Viewer from 'viewerjs'
import { assign } from './util'

const api = ({ images = [], options = {} } = {}) => {
  options = assign(options, {
    inline: false, 
  })
  const ViewerToken = Vue.extend({
    render(h) {
      return h(
        'div',
        {
          style: {
            display: 'none',
          },
          class: ['__viewer-token'],
        },
        images.map((attr) => {
          return h(
            'img',
            {
              attrs: typeof attr === 'string' ? { src: attr } : attr,
            },
          )
        }),
      )
    },
  })
  const token = new ViewerToken()
  token.$mount()
  document.body.appendChild(token.$el)

  const $viewer = new Viewer(token.$el, options)
  const $destroy = $viewer.destroy.bind($viewer)
  $viewer.destroy = function() {
    $destroy()
    token.$destroy()
    document.body.removeChild(token.$el)
    return $viewer
  }
  $viewer.show()

  token.$el.addEventListener('hidden', function() {
    if (this.viewer === $viewer) {
      $viewer.destroy()
    }
  })

  return $viewer
}

export default api
