import produce from "immer";

const projectReducer = (state, action) =>
  produce(state, draft => {
    switch (action.type) {
      case "CHANGE_INPUT": {
        let { name, value } = action.payload;
        draft[name] = value;
        return draft;
      }
      case "CHANGE_IS_SAVING_PROGRESS": {
        draft.is_saving = action.payload;
        return draft;
      }
      case "SIMPAN_ACTION":
        draft.is_saving = true;
        return draft;
      case "SIMPAN_SUCCESS":
        draft.save_success = true;
        return draft;
      case "SIMPAN_ERROR":
        draft.is_saving = false;
        return draft;
      case "RESET":
        draft = { ...initialState };
        return draft;
      default:
        return draft;
    }
  });

export default projectReducer;
