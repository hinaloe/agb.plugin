/**
 * BLOCK: Advertisement
 *
 * Display an ad
 */

import './style.scss';
import './editor.scss';

import classnames from 'classnames'

import Inspector from './inspect';

const { __ } = wp.i18n;

const {
  registerBlockType,
  RichText,
} = wp.blocks;


export default registerBlockType(
  'gutenblocks/addtocart',
  {
		title: __( 'Add to cart button' ),
    description: __( 'This button allow a customer to quickly add a product to cart' ),
    category: 'common',
    icon: 'cart',
    keywords: [
      __( 'purchase' ),
    ],
    attributes: {
      label: {
        type: 'string',
        source: 'text',
        selector: 'a',
				default: __( 'Add to cart' ),
      },
      url: {
        source: 'attribute',
        attribute: 'href',
        selector: 'a',
				default: '#',
      },
			price: {
				type: 'string',
        source: 'text',
        selector: '.wp-block-gutenblocks-addtocart__price',
			},
			salePrice: {
				type: 'string',
				source: 'text',
				selector: '.wp-block-gutenblocks-addtocart__sale-price',
			},
			hasIcon: {
        type: 'boolean',
        default: true,
      },
      icon: {
        source: 'attribute',
        attribute: 'data-icon',
        selector: '.dashicons',
        default: 'download',
      },
      backgroundColor: {
				type: 'string',
        default: '#9B6794',
      },
    },
    edit: props => {

			const onChangeProduct = product => {

        props.setAttributes( {
					label: __( 'Add ' ) + product.title.rendered + __( ' to cart' ),
					url: `/?add-to-cart=${product.id}`,
					price: product.price,
					salePrice: product.sale_price
				} )
      }

			const onChangeLabel = value => {
        props.setAttributes( { label: value } )
      }

      const onChangeURL = value => {
        props.setAttributes( { url: value } )
      }

			const onChangeBackgroundColor = value => {
        props.setAttributes( { backgroundColor: value } )
      }

      const onChangeIcon = value => {
        props.setAttributes( { icon: value } )
      };

      const toggleHasIcon = () => {
        props.setAttributes( { hasIcon: ! props.attributes.hasIcon } )
      }

      return [
        !! props.focus && (
          <Inspector { ...{ onChangeIcon, onChangeURL, toggleHasIcon, onChangeProduct, onChangeBackgroundColor, ...props } } />
        )
				,
        <p className={ props.className }>
          <a
						style={ {
	            backgroundColor: props.attributes.backgroundColor
	          } }
						className="wp-block-gutenblocks-addtocart__button"
					>
            { !! props.attributes.hasIcon && (
              <span className={ classnames('dashicons', `dashicons-${props.attributes.icon}`) }></span>
              )
            }
            <RichText
              tagName="span"
							className="wp-block-gutenblocks-addtocart__label"
              value={ props.attributes.label }
              onChange={ onChangeLabel }
            />
						<span className="wp-block-gutenblocks-addtocart__price">{ props.attributes.price }</span>
            <span className="wp-block-gutenblocks-addtocart__sale-price">{ props.attributes.salePrice }</span>
					</a>
				</p>
      ]
    },
    save: props => {
      return (
        <p>
          <a
						style={ {
	            backgroundColor: props.attributes.backgroundColor
	          } }
						className="wp-block-gutenblocks-addtocart__button"
            href={ props.attributes.url }
            data-type={ props.attributes.buttonClass }
          >
            { !! props.attributes.hasIcon && (
              <span
                className={ classnames('dashicons', `dashicons-${props.attributes.icon}`) }
                data-icon={ props.attributes.icon }
              >
              </span>
              )
            }
            <span className="wp-block-gutenblocks-addtocart__label">{ props.attributes.label }</span>
						•
            <span className="wp-block-gutenblocks-addtocart__price">{ props.attributes.price }</span>
            <span className="wp-block-gutenblocks-addtocart__sale-price">{ props.attributes.salePrice }</span>
          </a>
        </p>
      )
    },
  },
);