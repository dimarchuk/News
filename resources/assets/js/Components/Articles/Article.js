import React, { Component } from 'react';
import { Link } from 'react-router-dom';

export default class Article extends Component {
    constructor(props) {
        super();

        this.state = props;
    }

    render() {
        return(
            <div className="article__title">
                <Link className="article" to={'/article/' + this.state.article.id}>
                        <span>{this.state.article.title}</span>
                </Link>
            </div>
        );
    }
}