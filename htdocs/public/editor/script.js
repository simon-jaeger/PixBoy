// global listeners
////////////////////////////////////////////////////////////////////////////////
let pointerDown = false
$(window)
  .on("mousedown", () => (pointerDown = true))
  .on("mouseup", () => (pointerDown = false))

// editor: view model
////////////////////////////////////////////////////////////////////////////////
const editor = {
  // view selector
  el: "#editor",

  // model data
  data: {
    title: PHP.title,
    description: PHP.description,
    shadesArray: [...PHP.shadesArray],
    shadeActive: PHP.shadeActive,
    history: [],
    reverseHistory: [],
    formOpen: PHP.formOpen,
    isSubmitting: false,
  },

  // methods
  methods: {
    /**
     * paint a single pixel (only if pointer is down)
     * @param {number} index - index of target pixel (0 - 255)
     * @param {number} shade - shade to use (0, 1, 2, 3)
     */
    paint(index, shade) {
      if (!pointerDown) return
      Vue.set(editor.data.shadesArray, index, shade)
    },

    /**
     * paint pixel based on touch event
     * @param e {TouchEvent}
     */
    paintTouch(e) {
      let target
      // update target if moving across multiple pixel
      if (e.changedTouches.length) {
        target = document.elementFromPoint(
          e.changedTouches[0].clientX,
          e.changedTouches[0].clientY
        )
      } else {
        target = e.target
      }
      Vue.set(
        editor.data.shadesArray,
        target.dataset.i,
        editor.data.shadeActive
      )
    },

    /**
     * push current state to history
     * (also clears reverseHistory, saves max 16 entries)
     */
    historyPush() {
      editor.data.history.push([...editor.data.shadesArray])
      editor.data.reverseHistory = []
      if (editor.data.history.length > 16) {
        editor.data.history = editor.data.history.slice(-16)
      }
    },

    /**
     * load last entry from history
     * (also saves discarded state in reverseHistory)
     */
    historyPop() {
      if (!editor.data.history.length) return
      editor.data.reverseHistory.push([...editor.data.shadesArray])
      editor.data.shadesArray = editor.data.history.pop()
    },

    /**
     * load last entry from reverseHistory
     * (also saves discarded state in history)
     */
    reverseHistoryPop() {
      if (!editor.data.reverseHistory.length) return
      editor.data.history.push([...editor.data.shadesArray])
      editor.data.shadesArray = editor.data.reverseHistory.pop()
    },
  },
}

// instantiate vue
////////////////////////////////////////////////////////////////////////////////
editor.vm = new Vue({
  el: editor.el,
  data: editor.data,
  methods: editor.methods,
})

// warn if leaving without saving
////////////////////////////////////////////////////////////////////////////////
window.addEventListener("beforeunload", event => {
  if (!editor.data.isSubmitting && editor.data.history.length) {
    event.returnValue = true
  }
})
