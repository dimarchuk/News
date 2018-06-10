import React, { Component } from 'react';
import Axios from 'axios';

import { apiUrl } from "../../Helpers/index";

import './Advertise.css';

export default class Advertise extends Component {
    constructor() {
        super();

        this.state = {
            showDiscount: false
        };
    }

    componentWillMount() {
        Axios.get(`${apiUrl}advertising`)
            .then(response => {
                this.setState({
                    advertise: response.data,
                    price: response.data.price
                });
            })
            .catch(error => console.log(error))
    }

    onMouseOverHandler() {
        this.setState((prevState) => ({
            price: (prevState.price - prevState.price * 0.1).toFixed(2),
            showDiscount: true
        }));
    }

    onMouseOutHandler() {
        this.setState((prevState) => ({
            price: (prevState.price * 100 / 90).toFixed(2),
            showDiscount: false
        }));
    }

    render() {
        const advertise = this.state.advertise;
        const price = this.state.price;

        if (advertise) {
            return (
                <div className="advertise"
                     onMouseOver={this.onMouseOverHandler.bind(this)}
                     onMouseOut={this.onMouseOutHandler.bind(this)}>
                    <div className="advertise__title">
                        <span>{advertise.product_name}</span>
                    </div>
                    <div className="advertise__subtitle">
                        <span>{advertise.advertiser}</span>
                    </div>
                    <div className="advertise__price">
                        <span className='price'>{price}$</span>
                    </div>
                    <div className={"advertise__sale " + (this.state.showDiscount ? 'advertise__sale--active' : '')}>
                        <span>Купон на скидку - {advertise.discount} - примините и получите скидку 10%</span>
                    </div>
                </div>
            )
        } else {
            return <span></span>
        }
    }
}