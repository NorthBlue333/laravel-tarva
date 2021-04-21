import 'alpinejs'
import { debounce } from 'lodash'

window.__laraveladmin_navigation_toggleNav = function(target, force = false) {
  if (this.isLocked && !force) return
  this.$refs.profile.classList.toggle('text-3xl')
  this.$refs.profile.classList.toggle('text-6xl')
  target.classList.toggle('w-16')
  target.classList.toggle('w-56')
  const toggleClasses = dataName => {
    target.querySelectorAll(`[${dataName}]`).forEach(el => {
      const classes = el.getAttribute(dataName).split(',')
      const timeoutClasses = []
      for (const className of classes) {
        if (className.startsWith('opacity')) {
          timeoutClasses.push(className)
          continue
        }
        el.classList.toggle(className)
      }
      setTimeout(() => {
        for (const className of timeoutClasses) {
          el.classList.toggle(className)
        }
      }, 100)
    })
  }
  if (this.isClosed) {
    if (force) target.classList.toggle('fixed')
    toggleClasses('data-instant-toggle')
    setTimeout(() => {
      toggleClasses('data-toggle')
    }, 200)
  } else {
    toggleClasses('data-toggle')
    setTimeout(() => {
      toggleClasses('data-instant-toggle')
      if (force) target.classList.toggle('fixed')
    }, 200)
  }
  this.isClosed = !this.isClosed
}

window.__laraveladmin_navigation_lockNav = function(
  contentId,
  classesToToggle
) {
  this.toggleNav(this.$el, true)
  if (contentId && classesToToggle) {
    const el = document.querySelector(`#${contentId}`)
    classesToToggle
      .split(' ')
      .forEach(classItem => el.classList.toggle(classItem))
  }
  this.isLocked = !this.isLocked
}

window.__laraveladmin_navigation_dispatchLockNav = function($dispatch, e) {
  $dispatch('lock-nav')
  this.$el.classList.toggle('pl-20')
  this.$el.classList.toggle('pl-64')
  const icon =
    e.target.classList.contains('fa-arrow-right') ||
    e.target.classList.contains('fa-arrow-left')
      ? e.target
      : e.target.querySelector('.fa-arrow-right,.fa-arrow-left')
  icon.classList.toggle('fa-arrow-right')
  icon.classList.toggle('fa-arrow-left')
}

window.__laraveladmin_index_resourceIndexPageWithQuery = function() {
  window.location.href = encodeURI(
    `${this.route}?${Object.keys(this.indexPageParameters)
      .map(key => `${key}=${this.indexPageParameters[key]}`)
      .join('&')}`
  )
}

window.__laraveladmin_index_changeIndexPageParameters = function(
  paramName,
  value
) {
  this.indexPageParameters[paramName] = value
  this.resourceIndexPageWithQuery()
}

window.__laraveladmin_fields_media_deleteMedia = function(refs) {
  for (const ref of refs) {
    if (this.$refs[ref]) this.$refs[ref].remove()
  }
}

window.__laraveladmin_fields_media_addMedia = function(event) {
  this.$refs['media-list']
    .querySelectorAll('.new-media')
    .forEach(el => el.remove())

  const fileNames = []
  for (const file of event.target.files) {
    fileNames.push(file.name)
    const newPictureEl = document.createElement('picture')
    newPictureEl.className =
      'w-48 h-48 flex items-center justify-center shadow rounded border border-tertiary border-opacity-50 relative m-2 new-media'
    const newImgEl = document.createElement('img')
    newImgEl.className = 'max-w-full max-h-full'
    newImgEl.setAttribute('src', URL.createObjectURL(file))
    newPictureEl.appendChild(newImgEl)
    const newTextEl = document.createElement('p')
    newTextEl.className =
      'absolute top-2 left-2 text-ghost-white bg-tertiary rounded-full py-1 px-2 font-bold uppercase text-xs'
    newTextEl.innerText = 'nouveau'
    newPictureEl.appendChild(newTextEl)
    this.$refs['media-list'].appendChild(newPictureEl)
  }

  this.$refs['file-names'].innerText = fileNames.join(', ')
}

window.__laraveladmin_fields_wysiwyg_setFieldValue = function(event) {
  this.$refs.field.setAttribute('value', event.detail)
}

window.__laraveladmin_debounce = function(func, delay) {
  return debounce(func, delay)
}
