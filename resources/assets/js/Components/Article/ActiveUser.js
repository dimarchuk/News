import React, { Component } from 'react';

export default class ActiveUser extends Component {
    constructor(props) {
        super();

        this.state = {
            numberOfViews: props.users
        };

        this.props = props;
    }

    componentWillMount() {
        this.setActiveViewer();
    }

    setActiveViewer() {
        const activeViewer = Math.floor(Math.random() * (5 - 1) + 1);

        this.setState({
            activeViewer: activeViewer
        });

        this.props.callback(this.state.activeViewer);

        setTimeout(this.setActiveViewer.bind(this), 3000);

        this.setState((prevState) => ({
            numberOfViews: prevState.numberOfViews + prevState.activeViewer
        }));
    }

    render() {
        return(
            <div className="active-users">
                <span>Уже просмотрели: {this.state.numberOfViews}</span>
                <span>Сейчас смотрит: {this.state.activeViewer}</span>
            </div>
        )
    }
}