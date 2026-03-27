import React, { Fragment } from "react";
import classNames from "classnames";
import capitalize from "lodash/capitalize";
import { OptionGroup, ErrorMessage } from "../Form";
import { defaultErrorMessage } from "../../containers/Hse/constant";

const replaceSpace = (str) => str.replace(/\s/g, "_");

const InspectionItem = ({ inspection, errors, register, defaultChecked, defaultOptions, item_id }, ...otherProps) => {
  
  let inputClass = classNames({
    // "font-rubik border-2 border-black-500 flex items-center px-4 h-10 w-full lg:w-64 bg-gray-50 mt-2 mb-2 rounded": true,
    // "focus:outline-none focus:ring-2 focus:ring-blue-900": true,
    "form-control": true

  });
  let inputErrorClass = classNames({    
    "form-control": true,
    "border border-2 border-danger": true
  });

  return (
    <div className="flex flex-col w-80 lg:w-full px-2 lg:px-10 py-4 mt-3 mb-1 border-2 border-gray-200 rounded-lg">
      <h4 className="font-rubik font-semibold whitespace-nowrap my-3 lg:my-5 text-center lg:text-left">
        {capitalize(inspection.name)}
      </h4>
      {inspection.properties.map((item, id) => {
        return (
          <div key={`item-${id}`} className="flex flex-col lg:flex-row mb-3">
            <div className="flex lg:w-64 items-center h-10">
              <span className="text-black-300 font-weight-bold">
                {capitalize(item.name)}
              </span>
            </div>
            <div className="flex-initial-1 mb-1 lg:mb-0 items-end lg:items-center">
              {item.input.type === "optionGroup" && (
                <Fragment>
                  <div className="flex flex-row">
                    <OptionGroup
                      name={`${item_id}_${replaceSpace(item.name).toLowerCase()}`}
                      options={defaultOptions}
                      defaultChecked={defaultChecked}
                      className={
                        errors[`${item_id}_${replaceSpace(item.name).toLowerCase()}`]
                          ? inputErrorClass
                          : inputClass
                      }
                      register={register}
                    />
                  </div>
                  {errors[`${item_id}_${replaceSpace(item.name).toLowerCase()}`] && (
                    <ErrorMessage message={defaultErrorMessage} />
                  )}
                </Fragment>
              )}
              {item.input.type !== "option" &&
                item.input.type !== "optionGroup" && (
                  <Fragment>
                    <input
                      type={item.input.type}
                      className={
                        errors[`${item_id}_${replaceSpace(item.name).toLowerCase()}`]
                          ? inputErrorClass
                          : inputClass
                      }
                      {...register(item_id + '_' + replaceSpace(item.name).toLowerCase())}
                    />
                    {/*  */}
                    {errors[`${item_id}_${replaceSpace(item.name).toLowerCase()}`] && (
                      <ErrorMessage message={defaultErrorMessage} />
                    )}
                  </Fragment>
                )}
            </div>
          </div>
        );
      })}
    </div>
  );
}

export default InspectionItem;