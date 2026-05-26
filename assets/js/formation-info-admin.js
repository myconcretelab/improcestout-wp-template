( function () {
	function getRows( tbody ) {
		return Array.prototype.slice.call( tbody.querySelectorAll( '[data-formation-info-row]' ) );
	}

	function getVisibleRows( tbody ) {
		return getRows( tbody ).filter( function ( row ) {
			return ! row.classList.contains( 'is-delete-pending' );
		} );
	}

	function updateOrders( tbody ) {
		getVisibleRows( tbody ).forEach( function ( row, index ) {
			var input = row.querySelector( '[data-formation-info-order]' );

			if ( input ) {
				input.value = String( ( index + 1 ) * 10 );
			}
		} );
	}

	function getRowAfterPointer( tbody, y ) {
		return getVisibleRows( tbody ).reduce( function ( closest, row ) {
			var box;
			var offset;

			if ( row.classList.contains( 'is-dragging' ) ) {
				return closest;
			}

			box = row.getBoundingClientRect();
			offset = y - box.top - box.height / 2;

			if ( offset < 0 && offset > closest.offset ) {
				return {
					offset: offset,
					row: row,
				};
			}

			return closest;
		}, {
			offset: Number.NEGATIVE_INFINITY,
			row: null,
		} ).row;
	}

	function setIconPickerOpen( picker, isOpen ) {
		var toggle;

		if ( ! picker ) {
			return;
		}

		toggle = picker.querySelector( '[data-formation-icon-toggle]' );
		picker.classList.toggle( 'is-open', !! isOpen );

		if ( toggle ) {
			toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
		}
	}

	function closeIconPickers( exceptPicker ) {
		Array.prototype.forEach.call( document.querySelectorAll( '[data-formation-icon-picker].is-open' ), function ( picker ) {
			if ( picker !== exceptPicker ) {
				setIconPickerOpen( picker, false );
			}
		} );
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		var tbody = document.querySelector( '[data-formation-info-sortable]' );
		var draggedRow = null;

		if ( ! tbody ) {
			return;
		}

		updateOrders( tbody );

		tbody.addEventListener( 'dragstart', function ( event ) {
			var row = event.target.closest( '[data-formation-info-row]' );

			if ( ! row || ! event.target.closest( '.impro-formation-info-settings__handle' ) ) {
				event.preventDefault();
				return;
			}

			draggedRow = row;
			row.classList.add( 'is-dragging' );
			event.dataTransfer.effectAllowed = 'move';
			event.dataTransfer.setData( 'text/plain', row.querySelector( 'code' ) ? row.querySelector( 'code' ).textContent : '' );
		} );

		tbody.addEventListener( 'dragover', function ( event ) {
			var afterRow;
			var newRow;

			if ( ! draggedRow ) {
				return;
			}

			event.preventDefault();
			afterRow = getRowAfterPointer( tbody, event.clientY );
			newRow = tbody.querySelector( '.impro-formation-info-settings__new-row' );

			if ( afterRow ) {
				tbody.insertBefore( draggedRow, afterRow );
			} else if ( newRow ) {
				tbody.insertBefore( draggedRow, newRow );
			} else {
				tbody.appendChild( draggedRow );
			}
		} );

		tbody.addEventListener( 'dragend', function () {
			if ( draggedRow ) {
				draggedRow.classList.remove( 'is-dragging' );
			}

			draggedRow = null;
			updateOrders( tbody );
		} );

		tbody.addEventListener( 'click', function ( event ) {
			var button = event.target.closest( '[data-formation-info-delete-button]' );
			var row;
			var input;

			if ( ! button ) {
				return;
			}

			row = button.closest( '[data-formation-info-row]' );
			input = row ? row.querySelector( '[data-formation-info-delete]' ) : null;

			if ( input ) {
				input.value = '1';
			}

			if ( row ) {
				row.classList.add( 'is-delete-pending' );
				row.draggable = false;
			}

			updateOrders( tbody );
		} );

			if ( tbody.closest( 'form' ) ) {
				tbody.closest( 'form' ).addEventListener( 'submit', function () {
					var newOrder = tbody.closest( 'form' ).querySelector( 'input[name="formation_info_new_item[order]"]' );

				updateOrders( tbody );

				if ( newOrder ) {
					newOrder.value = String( ( getVisibleRows( tbody ).length + 1 ) * 10 );
					}
				} );
			}

			document.addEventListener( 'click', function ( event ) {
				var toggle = event.target.closest( '[data-formation-icon-toggle]' );
				var close = event.target.closest( '[data-formation-icon-close]' );
				var picker = event.target.closest( '[data-formation-icon-picker]' );

				if ( toggle ) {
					picker = toggle.closest( '[data-formation-icon-picker]' );
					closeIconPickers( picker );
					setIconPickerOpen( picker, ! picker.classList.contains( 'is-open' ) );
					return;
				}

				if ( close ) {
					setIconPickerOpen( close.closest( '[data-formation-icon-picker]' ), false );
					return;
				}

				if ( ! picker ) {
					closeIconPickers();
				}
			} );

			document.addEventListener( 'keydown', function ( event ) {
				if ( event.key === 'Escape' ) {
					closeIconPickers();
				}
			} );

			document.addEventListener( 'change', function ( event ) {
				var input = event.target.closest( '[data-formation-icon-picker] input[type="radio"]' );
				var picker;
				var selectedLabel;
				var selectedSvg;
				var currentLabel;
				var currentSvg;

				if ( ! input ) {
					return;
				}

				picker = input.closest( '[data-formation-icon-picker]' );
				selectedLabel = input.getAttribute( 'data-icon-label' ) || input.value;
				selectedSvg = input.nextElementSibling ? input.nextElementSibling.querySelector( 'svg' ) : null;
				currentLabel = picker.querySelector( '[data-formation-icon-current-label]' );
				currentSvg = picker.querySelector( '[data-formation-icon-current-svg]' );

				if ( currentLabel ) {
					currentLabel.textContent = selectedLabel;
				}

				if ( currentSvg && selectedSvg ) {
					currentSvg.innerHTML = selectedSvg.outerHTML;
				}

				setIconPickerOpen( picker, false );
			} );
		} );
	} )();
