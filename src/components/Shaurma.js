import React, { Component } from 'react';
import '../components/Shaurma.css';


class Shaurma extends Component {
  render() {
    return (
      <div className="header">
        <h1>Шаурмы</h1>
        {
          this.props.data.map((item, index) => {
            if (item.title === "Шаурма") {
              return (
                <div className="fastFoots">
                <div>{item.place}</div>
                  <div>{item.title}</div>
                  <div>{item.cost} сом </div>
                  <img className="shav"
                    src={item.img}
                  ></img>
                </div>
              )
            }
          })
        }
      </div>
    );
  };
};
export default Shaurma;