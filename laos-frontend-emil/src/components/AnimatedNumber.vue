<template>
  <span>
    <template v-if="separate">
      {{ animatedNumber | formatNumber }}
    </template>
    <template v-else>
      {{ animatedNumber }}
    </template>
  </span>
</template>
<script>
import TWEEN from '@tweenjs/tween.js'

export default {
  props: {
    value: {
      default: 0
    },
    duration: {
      type: Number,
      default: 800
    },
    separate: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      animatedNumber: 0
    }
  },
  methods: {
    initAnimation(newValue, oldValue) {
      let vm = this

      function animate() {
        if (TWEEN.update()) {
          requestAnimationFrame(animate)
        }
      }

      const is_float_val = newValue.toString().indexOf('.')
      const float_length = ~is_float_val
          ? newValue.toString().length - is_float_val - 1
          : 0

      new TWEEN.Tween({tweeningNumber: oldValue})
          .easing(TWEEN.Easing.Quadratic.Out)
          .to({tweeningNumber: newValue}, this.duration)
          .onUpdate(function (object) {
            vm.animatedNumber = object.tweeningNumber.toFixed(float_length)
          })
          .start()

      animate()
    }
  },
  mounted() {
    this.initAnimation(this.value, 0)
  },
  watch: {
    value(newValue, oldValue) {
      this.initAnimation(newValue, oldValue)
    }
  }
}
</script>
<style></style>
