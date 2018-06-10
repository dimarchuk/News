import React, { Component } from 'react';

import SlideElement from './SlideElement';
import './Slider.css';


export default class Slider extends Component {
    constructor(props) {
        super();

        this.state = props;
        this.sliderTimer = null;
    }

    componentWillMount() {
        this.setState({
            activeSlide: 0
        });
    }

    componentDidMount() {
        this.mountSlider();
    }

    componentWillUnmount() {
        clearInterval(this.sliderTimer);
    }

    mountSlider() {
        this.sliderTimer = setInterval(() => {
            if (this.state.activeSlide !== this.state.slides.length - 1) {
                this.setState((prevState, state) => ({
                    activeSlide: prevState.activeSlide + 1
                }));
            } else {
                this.setState({
                    activeSlide: 0
                });
            }
        }, 1500);
    }

    toLeft() {
        clearInterval(this.sliderTimer);

        if (this.state.activeSlide !== 0) {
            this.setState((prevState, state) => ({
                activeSlide: prevState.activeSlide - 1
            }));
        } else {
            this.setState({
                activeSlide: this.state.slides.length - 1
            });
        }
    }

    toRight() {
        clearInterval(this.sliderTimer);

        if (this.state.activeSlide !== this.state.slides.length - 1) {
            this.setState((prevState, state) => ({
                activeSlide: prevState.activeSlide + 1
            }));
        } else {
            this.setState({
                activeSlide: 0
            });
        }
    }

    render() {
        const activeSlide = this.state.slides[this.state.activeSlide];

        return (
            <div className="slider">
                <button className="slider__btn" onClick={this.toLeft.bind(this)}>
                    left
                </button>
                <div className="slider__content">
                    <SlideElement dataSlide={activeSlide} />
                </div>
                <button className="slider__btn" onClick={this.toRight.bind(this)}>
                    right
                </button>
            </div>
        );
    }
}