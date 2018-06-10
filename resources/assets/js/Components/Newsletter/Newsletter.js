import React, { Component } from 'react';

import './Newsletter.css';

export default class Newsletter extends Component {
    constructor() {
        super();

        this.state = {show: false};
    }

    componentWillMount() {
        this.setTimer();
    }

    setTimer() {
        setTimeout(() => {
            this.setState({
                show: true
            });
        }, 15000);
    }

    closeWindow() {
        this.setState({
            show: false
        });
    }

    render() {
        const isShow = this.state.show;

        return(
            <div className={isShow ? "newsletter" : "newsletter--hide"}>
                <div className="newsletter__close" onClick={this.closeWindow.bind(this)}>X</div>
                <div className="newsletter__title">
                    <span>Подпишитесь на рассылку</span>
                </div>
                <form action="">
                    <input className='input-element' type="email" value='' placeholder='E-mail' />
                    <input className='input-element' type="text" value='' placeholder='Имя' />
                    <input className='input-element' type="text" value='' placeholder='Фамилия' />
                </form>
            </div>
        );
    }
}