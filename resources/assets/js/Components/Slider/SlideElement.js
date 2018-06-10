import React, { Component } from 'react';

import './SlideElemens.css';

export default class SlideElement extends Component {
    constructor(props) {
        super();

        this.props = props;
    }

    render() {
        return (
            <div className="slide" id={this.props.dataSlide.id}>
                <div className="slide__title">
                    <span>{this.props.dataSlide.title}</span>
                </div>
                <div className="slide__category">
                    <span>{this.props.dataSlide.category}</span>
                </div>
                <div className="slide__picture">
                    <img className="picture" src={this.props.dataSlide.img} alt=""/>
                </div>
            </div>
        );
    }
}